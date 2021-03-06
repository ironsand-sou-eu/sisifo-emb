<?php

namespace App\Http\Controllers;

use App\Models\BizRules\CustasConfig;
use Illuminate\Http\Request;

class CustasConfigsController extends Controller
{
    protected $mainModel = \App\Models\BizRules\CustasConfig::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Configurações - Sísifo DAJEs',
            'description' => 'Configurações necessárias para a geração dos dados pelo Sísifo DAJEs',
            'url' => url('/custas-configs'),
            'apiUrl' => url('/api/custas-configs'),
            'dbFieldNames' => ['nome', 'valor'],
            'dbNameField' => 'nome',
            'dbIdField' => 'id',
            'tableColumnNames' => ['Nome', 'Valor da configuração'],
        ];
        return $this->generalIndex($request, $params);
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
            'nome' => ['required', 'max:50', 'unique:custas_configs'],
            'valor' => ['required'],
        ];

        return $this->validateAndStore($request, $this->mainModel, $validationRules);
    }

    /**
     * Open resource's creation form in frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\View
     */
    public function create(Request $request)
    {
        if ($this->isApiRoute($request)) {
            return response('', 404);
        }

        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Nova configuração do Sísifo DAJEs',
            'description' => 'A configuração abaixo refere-se aos valores que o Sísifo DAJEs insere na planilha'.
                'que será importada para o SAP. Não altere sem compreender os efeitos. Se precisar de ajuda para'.
                'compreender, procure o financeiro da PPJ',
            'url' => url('/custas-configs'),
            'apiUrl' => url('/api/custas-configs'),
            'displayFields' => [
                0 => ['name' => 'nome', 'caption' => 'Nome da configuração', 'inputType' => 'text', 'bootstrapColSize' => 6],
                1 => ['name' => 'valor', 'caption' => 'Valor', 'inputType' => 'text', 'bootstrapColSize' => 6],
            ],
        ];

        return view('components.new', $params);
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
            'description' => 'A configuração abaixo refere-se aos valores que o Sísifo DAJEs insere na planilha'.
                'que será importada para o SAP. Não altere sem compreender os efeitos. Se precisar de ajuda para'.
                'compreender, procure o financeiro da PPJ.',
            'id' => $id,
            'url' => url('/custas-configs'),
            'apiUrl' => url('/api/custas-configs'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome', 'caption' => 'Nome da configuração', 'inputType' => 'text', 'bootstrapColSize' => 6],
                1 => ['name' => 'valor', 'caption' => 'Valor', 'inputType' => 'text', 'bootstrapColSize' => 6],
            ],
        ];

        return view('components.edit', $params);
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
            'nome' => ['required', 'string', 'max:50'],
            'valor' => ['string'],
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
