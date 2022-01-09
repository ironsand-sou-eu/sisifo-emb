<?php

namespace App\Http\Controllers;

use App\Models\Access\Campo;
use Illuminate\Http\Request;
use App\Rules\UniqueCombinationRule;

class CamposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = Campo::with(["tabela"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Campos',
                'description' => 'Campos que compõem as tabelas do Sísifo',
                'url' => url('/campos'),
                'apiUrl' => url('/api/campos'),
                'dbFieldNames' => ["nome_campo", "tabela.nome_tabela"],
                'dbNameField' => "nome_campo",
                'dbIdField' => "id",
                'tableColumnNames' => ['Campo', 'Tabela']
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
        $nomeCampo = $request->input("nome_campo");
        $validationRules = [
            "nome_campo" => ["required", "max:191"],
            "tabela_id" => ["required", "numeric", new UniqueCombinationRule(Campo::class, ['nome_campo', $nomeCampo])]
        ];

        return $this->validateAndStore($request, Campo::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = Campo::findOrFail($id);
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
        $nomeCampo = $request->input("nome_campo");
        $validationRules = [
            "nome_campo" => ["max:191"],
            "tabela_id" => ["numeric", new UniqueCombinationRule(Campo::class, ['nome_campo', $nomeCampo])]
        ];

        return $this->validateAndUpdate($request, Campo::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(Campo::class, $id);
    }
}
