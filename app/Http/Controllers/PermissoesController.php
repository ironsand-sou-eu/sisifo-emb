<?php

namespace App\Http\Controllers;

use App\Models\Access\Permissao;
use App\Models\Access\Tabela;
use App\Models\Access\TipoPermissao;
use App\Models\Access\User;
use App\Rules\UniqueCombinationRule;
use Illuminate\Http\Request;

class PermissoesController extends Controller
{
    protected $mainModel = \App\Models\Access\Permissao::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::with(['user', 'tabela', 'tipoPermissao'])->get();

            return response()->json(['fullList' => $fullList]);
        } else {
            $jwt = $request->cookie('jat');

            return view('components.index', [
                'jwt' => $jwt,
                'title' => 'Permissões',
                'description' => 'Permissões dos usuários do Sísifo',
                'url' => url('/permissoes'),
                'apiUrl' => url('/api/permissoes'),
                'dbFieldNames' => ['user.nome_escolhido', 'tabela.nome_tabela', 'tipo_permissao.nome_permissao'],
                'dbNameField' => 'user.nome_escolhido',
                'dbIdField' => 'id',
                'tableColumnNames' => ['Usuário', 'Tabela', 'Permissão'],
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
        $userId = $request->input('user_id');
        $validationRules = [
            'user_id' => ['required', 'numeric'],
            'tipo_permissao_id' => ['required', 'numeric'],
            'tabela_id' => ['required', 'numeric', new UniqueCombinationRule(Permissao::class, 'user_id', $userId)],
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

        $users = User::all();
        $tabelas = Tabela::all();
        $tiposPermissao = TipoPermissao::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Nova permissão',
            'description' => 'Use esta tela para aplicar uma permissão a um usuário.',
            'url' => url('/permissoes'),
            'apiUrl' => url('/api/permissoes'),
            'displayFields' => [
                0 => ['name' => 'user_id', 'caption' => 'Usuário', 'inputType' => 'select', 'options' => $users, 'id' => 'id', 'value' => 'nome_escolhido'],
                1 => ['name' => 'tabela_id', 'caption' => 'Tabela', 'inputType' => 'select', 'options' => $tabelas, 'id' => 'id', 'value' => 'nome_tabela'],
                2 => ['name' => 'tipo_permissao_id', 'caption' => 'Permissão', 'inputType' => 'select', 'options' => $tiposPermissao, 'id' => 'id', 'value' => 'nome_permissao'],
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

        $entity = $this->mainModel::with(['user', 'tabela', 'tipoPermissao'])->find($id);
        $users = User::all();
        $tabelas = Tabela::all();
        $tiposPermissao = TipoPermissao::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando permissão',
            'description' => '',
            'id' => $id,
            'url' => url('/permissoes'),
            'apiUrl' => url('/api/permissoes'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'user_id', 'caption' => 'Usuário', 'inputType' => 'select', 'options' => $users, 'id' => 'id', 'value' => 'nome_escolhido', 'selected' => $entity->user->nome_escolhido],
                1 => ['name' => 'tabela_id', 'caption' => 'Tabela', 'inputType' => 'select', 'options' => $tabelas, 'id' => 'id', 'value' => 'nome_tabela', 'selected' => $entity->tabela->nome_tabela],
                2 => ['name' => 'tipo_permissao_id', 'caption' => 'Permissão', 'inputType' => 'select', 'options' => $tiposPermissao, 'id' => 'id', 'value' => 'nome_permissao', 'selected' => $entity->tipoPermissao->nome_permissao],
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
        $userId = $request->input('user_id');
        $validationRules = [
            'user_id' => ['numeric'],
            'tipo_permissao_id' => ['numeric'],
            'tabela_id' => ['numeric'],
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
