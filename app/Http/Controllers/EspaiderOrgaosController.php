<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderOrgao;
use Illuminate\Http\Request;

class EspaiderOrgaosController extends Controller
{
    protected $mainModel = 'App\Models\BizRules\EspaiderOrgao';
    
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
                'title' => 'Órgãos',
                'description' => 'Juízos existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/espaider-orgaos'),
                'apiUrl' => url('/api/espaider-orgaos'),
                'dbFieldNames' => ["nome_orgao_espaider", "sigla_orgao"],
                'dbNameField' => "nome_orgao_espaider",
                'dbIdField' => "id",
                'tableColumnNames' => ['Órgão (Espaider)', 'Sigla']
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
            "nome_orgao_espaider" => ["required", "min:3", "max:90", "unique:espaider_orgaos"],
            "sigla_orgao" => ["required", "min:2", "max:25"],
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
            'title' => 'Editando órgão (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'id' => $id,
            'url' => url('/espaider-orgaos'),
            'apiUrl' => url('/api/espaider-orgaos'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_orgao_espaider', 'caption' => 'Nome do órgão', 'inputType' => 'text'],
                0 => ['name' => 'sigla_orgao', 'caption' => 'Sigla', 'inputType' => 'text']
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
            "nome_orgao_espaider" => ["required", "min:3", "max:90"],
            "sigla_orgao" => ["required", "min:2", "max:25"],
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
