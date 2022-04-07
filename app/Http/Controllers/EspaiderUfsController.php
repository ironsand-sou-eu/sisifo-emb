<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderUf;
use Illuminate\Http\Request;

class EspaiderUfsController extends Controller
{
    protected $mainModel = \App\Models\BizRules\EspaiderUf::class;

    public function index(Request $request)
    {
        $params = [
            'title' => 'UFs',
            'description' => 'Unidades da Federação existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
            'url' => url('/espaider-ufs'),
            'apiUrl' => url('/api/espaider-ufs'),
            'dbFieldNames' => ['nome', 'sigla'],
            'dbNameField' => 'nome',
            'dbIdField' => 'sigla',
            'tableColumnNames' => ['UF', 'Sigla'],
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
            'nome_uf_espaider' => ['required', 'min:4', 'max:25', 'unique:espaider_ufs'],
            'sigla' => ['required', 'regex:/^[A-Z]{2}$/', 'unique:espaider_ufs'],
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
            'title' => 'Nova Unidade da Federação (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/espaider-ufs'),
            'apiUrl' => url('/api/espaider-ufs'),
            'displayFields' => [
                0 => ['name' => 'nome_uf_espaider', 'caption' => 'Unidade da Federação (Espaider)', 'inputType' => 'text', 'bootstrapColSize' => 8],
                1 => ['name' => 'sigla', 'caption' => 'Sigla', 'inputType' => 'text', 'bootstrapColSize' => 4],
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
            'title' => 'Editando UF (redação do Espaider)',
            'description' => 'Unidades da Federação',
            'id' => $entity->sigla,
            'url' => url('/espaider-ufs'),
            'apiUrl' => url('/api/espaider-ufs'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_uf_espaider', 'caption' => 'Nome', 'inputType' => 'text', 'bootstrapColSize' => 8],
                1 => ['name' => 'sigla', 'caption' => 'Sigla', 'inputType' => 'text', 'bootstrapColSize' => 4],
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
            'nome_uf_espaider' => ['min:4', 'max:25'],
            'sigla' => ['regex:/^[A-Z]{2}$/'],
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
