<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloConfig;
use Illuminate\Http\Request;

class EseloConfigsController extends Controller
{
    protected $mainModel = 'App\Models\BizRules\EseloConfig';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Configurações - Sísifo DAJEs',
                'description' => 'Configurações necessárias para a geração dos dados pelo Sísifo DAJEs',
                'url' => url('/eselo-configs'),
                'apiUrl' => url('/api/eselo-configs'),
                'dbFieldNames' => ["nome", "valor"],
                'dbNameField' => "nome",
                'dbIdField' => "id",
                'tableColumnNames' => ['Nome', "Valor da configuração"]
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
            "nome" => ["required", "max:50", "unique:nome"],
            "valor" => ["required"],
        ];    
        return $this->validateAndStore($request, $this->mainModel, $validationRules);
    }

        /**
     * Open the specified resource for edition in frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit(Request $request, $id)
    {
        if ($this->isApiRoute($request)) {
            return response('', 404);
        }

        $entity = $this->mainModel::find($id);
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando configuração do Sísifo DAJEs',
            'description' => 'A configuração abaixo refere-se aos valores que o Sísifo DAJEs insere na planilha' . 
                'que será importada para o SAP. Não altere sem compreender os efeitos. Se precisar de ajuda para' . 
                'compreender, procure o financeiro da PPJ',
            'id' => $id,
            'url' => url('/eselo-configs'),
            'apiUrl' => url('/api/eselo-configs'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome', 'caption' => 'Nome da configuração', 'inputType' => 'text'],
                1 => ['name' => 'valor', 'caption' => 'Valor', 'inputType' => 'text']
            ]
        ];

        return view("components.edit", $params);
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
            "nome" => ["required", "max:50"],
            "valor" => ["required"],
        ];    
        return $this->validateAndUpdate($request, $this->mainModel, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete($this->mainModel, $id);
    }
}
