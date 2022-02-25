<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderOrgao;
use Illuminate\Http\Request;

class EspaiderOrgaosController extends Controller
{
    protected $mainModel = \App\Models\BizRules\EspaiderOrgao::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Órgãos',
            'description' => 'Juízos existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
            'url' => url('/espaider-orgaos'),
            'apiUrl' => url('/api/espaider-orgaos'),
            'dbFieldNames' => ['nome', 'sigla'],
            'dbNameField' => 'nome',
            'dbIdField' => 'id',
            'tableColumnNames' => ['Órgão (Espaider)', 'Sigla'],
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
            'nome_orgao_espaider' => ['required', 'min:3', 'max:90', 'unique:espaider_orgaos'],
            'sigla_orgao' => ['required', 'min:2', 'max:25'],
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
            'title' => 'Novo órgão (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/espaider-orgaos'),
            'apiUrl' => url('/api/espaider-orgaos'),
            'displayFields' => [
                0 => ['name' => 'nome_orgao_espaider', 'caption' => 'Órgão (Espaider)', 'inputType' => 'text', 'bootstrapColSize' => 8],
                1 => ['name' => 'sigla_orgao', 'caption' => 'Sigla', 'inputType' => 'text', 'bootstrapColSize' => 4],
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
            'title' => 'Editando órgão (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'id' => $id,
            'url' => url('/espaider-orgaos'),
            'apiUrl' => url('/api/espaider-orgaos'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_orgao_espaider', 'caption' => 'Nome do órgão', 'inputType' => 'text', 'bootstrapColSize' => 8],
                1 => ['name' => 'sigla_orgao', 'caption' => 'Sigla', 'inputType' => 'text', 'bootstrapColSize' => 4],
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
            'nome_orgao_espaider' => ['required', 'min:3', 'max:90'],
            'sigla_orgao' => ['required', 'min:2', 'max:25'],
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
