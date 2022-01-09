<?php

namespace App\Http\Controllers;

use App\Models\Access\TipoPermissao;
use Illuminate\Http\Request;

class TiposPermissoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = TipoPermissao::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Tipos de permissão',
                'description' => 'Tipos de permissão a serem aplicadas aos usuários',
                'url' => url('/tipos-permissoes'),
                'apiUrl' => url('/api/tipos-permissoes'),
                'dbFieldNames' => ["nome_permissao"],
                'dbNameField' => "nome_permissao",
                'dbIdField' => "id",
                'tableColumnNames' => ['Permissão']
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
            "nome_permissao" => ["required", "max:10", "unique:tipos_permissoes"],
        ];
        return $this->validateAndStore($request, TipoPermissao::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = TipoPermissao::findOrFail($id);
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
            "nome_permissao" => ["max:10", "unique:tipos_permissoes"],
        ];
        return $this->validateAndUpdate($request, TipoPermissao::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(TipoPermissao::class, $id);
    }
}
