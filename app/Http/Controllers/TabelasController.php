<?php

namespace App\Http\Controllers;

use App\Models\Access\Tabela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TabelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = Tabela::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Tabelas',
                'description' => 'Tabelas que compõem o banco de dados do Sísifo',
                'url' => url('/tabelas'),
                'apiUrl' => url('/api/tabelas'),
                'dbFieldNames' => ["nome_tabela"],
                'dbNameField' => "nome_tabela",
                'dbIdField' => "id",
                'tableColumnNames' => ['Tabela']
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            "nome_tabela" => ["required", "max:60", "unique:tabelas"]
        ];
        return $this->validateAndStore($request, Tabela::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = Tabela::findOrFail($id);
        return response()->json(["entity" => $entity]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validationRules = [
            "nome_tabela" => ["max:60", "unique:tabelas"]
        ];
        return $this->validateAndUpdate($request, Tabela::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(Tabela::class, $id);
    }
}
