<?php

namespace App\Http\Controllers;

use App\Models\Access\TipoPermissao;
use Illuminate\Http\Request;

class TiposPermissoesController extends Controller
{
    protected $mainModel = \App\Models\Access\TipoPermissao::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Tipos de permissão',
            'description' => 'Tipos de permissão a serem aplicadas aos usuários',
            'url' => url('/tipos-permissoes'),
            'apiUrl' => url('/api/tipos-permissoes'),
            'dbFieldNames' => ['nome_permissao'],
            'dbNameField' => 'nome_permissao',
            'dbIdField' => 'id',
            'tableColumnNames' => ['Permissão'],
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
            'nome_permissao' => ['required', 'max:10', 'unique:tipos_permissoes'],
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
            'title' => 'Novo tipo de permissão',
            'description' => 'Esta tabela serve para criar um novo tipo/nível de permissão. Para aplicar permissões'.
                'a usuários concretos, use o menu "Permissões".',
            'url' => url('/tipos-permissoes'),
            'apiUrl' => url('/api/tipos-permissoes'),
            'displayFields' => [
                0 => ['name' => 'nome_permissao', 'caption' => 'Nome da permissão', 'inputType' => 'text', 'bootstrapColSize' => 6],
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
            'title' => 'Editando tipo de permissão',
            'description' => '',
            'id' => $id,
            'url' => url('/tipos-permissoes'),
            'apiUrl' => url('/api/tipos-permissoes'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_permissao', 'caption' => 'Tipo de permissão', 'inputType' => 'text', 'bootstrapColSize' => 6],
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
            'nome_permissao' => ['max:10'],
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
