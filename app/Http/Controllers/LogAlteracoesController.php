<?php

namespace App\Http\Controllers;

use App\Models\Access\LogAlteracao;
use Illuminate\Http\Request;

class LogAlteracoesController extends Controller
{
    protected $mainModel = 'App\Models\Access\LogAlteracao';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::with(["campo", "alteradoPor"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Log de Alterações',
                'description' => '',
                'url' => url('/log-alteracoes'),
                'apiUrl' => url('/api/log-alteracoes'),
                'dbFieldNames' => ["campo.nome_campo", "valor_anterior", "valor_atual", "data_alteracao", "alterado_por.nome_escolhido"],
                'dbNameField' => "valor_atual",
                'dbIdField' => "id",
                'tableColumnNames' => ['Campo', 'Valor anterior', 'Valor atual', 'Data da alteração', 'Alterado por']
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
            "campo_id" => ["required", "numeric"],
            "valor_anterior" => ["required", "max:150"],
            "valor_atual" => ["required", "max:150"],
            "data_alteracao" => ["required", "date"],
            "alterado_por" => ["required", "numeric"]
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
            'title' => 'Visualizando registro de alteração',
            'description' => '',
            'id' => $id,
            'url' => url('/log-alteracoes'),
            'apiUrl' => url('/api/log-alteracoes'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'valor_anterior', 'caption' => 'Valor original', 'inputType' => 'text'],
                1 => ['name' => 'valor_atual', 'caption' => 'Valor alterado', 'inputType' => 'text'],
                2 => ['name' => 'data_alteracao', 'caption' => 'Data da alteração', 'inputType' => 'datetime']
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
            "campo_id" => ["numeric"],
            "valor_anterior" => ["max:150"],
            "valor_atual" => ["max:150"],
            "data_alteracao" => ["date"],
            "alterado_por" => ["numeric"]
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
