<?php

namespace App\Http\Controllers;

use App\Models\Access\Genero;
use App\Models\Access\User;
use Illuminate\Http\Request;
use App\Http\Resources\GlobalResource;

class UsersController extends Controller
{
    protected $mainModel = \App\Models\Access\User::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Usuários',
            'description' => 'Usuários do Sísifo',
            'url' => url('/users'),
            'apiUrl' => url('/api/users'),
            'dbFieldNames' => [
                'nomeEscolhido',
                'nomeCompleto',
                'email',
                'generoDeclarado.genero',
                'ativo'
            ],
            'dbNameField' => 'nome_escolhido',
            'dbIdField' => 'id',
            'tableColumnNames' => [
                'Nome',
                'Nome completo',
                'E-mail',
                'Gênero',
                'Ativo'
            ],
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
            'nome_completo' => ['required', 'min:5', 'max:100'],
            'nome_escolhido' => ['nullable', 'min:2', 'max:50'],
            'genero_declarado_id' => ['required', 'numeric'],
            'email' => ['required', 'email', 'unique:users'],
            'email_verified_at' => ['nullable', 'date'],
            'password' => ['required'],
            'remember_token' => ['nullable', 'max:100'],
            'ativo' => ['required', 'boolean'],
            'avatar_path' => ['nullable'],
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

        $generos = Genero::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Novo usuário',
            'description' => '',
            'url' => url('/users'),
            'apiUrl' => url('/api/users'),
            'displayFields' => [
                0 => ['name' => 'nome_escolhido', 'caption' => 'Nome', 'inputType' => 'text'],
                1 => ['name' => 'nome_completo', 'caption' => 'Nome completo', 'inputType' => 'text'],
                2 => ['name' => 'email', 'caption' => 'E-mail', 'inputType' => 'text', 'bootstrapColSize' => 6],
                3 => ['name' => 'genero_declarado_id', 'caption' => 'Gênero', 'inputType' => 'select', 'options' => $generos, 'id' => 'id', 'value' => 'genero', 'bootstrapColSize' => 6],
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

        $entity = $this->mainModel::with('generoDeclarado')->find($id);
        $generos = Genero::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando Usuário',
            'description' => '',
            'id' => $id,
            'url' => url('/users'),
            'apiUrl' => url('/api/users'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_escolhido', 'caption' => 'Nome', 'inputType' => 'text'],
                1 => ['name' => 'nome_completo', 'caption' => 'Nome completo', 'inputType' => 'text'],
                2 => ['name' => 'email', 'caption' => 'E-mail', 'inputType' => 'text', 'bootstrapColSize' => 6],
                3 => ['name' => 'genero_declarado_id', 'caption' => 'Gênero', 'inputType' => 'select', 'options' => $generos, 'id' => 'id', 'value' => 'genero', 'selected' => $entity->generoDeclarado->genero, 'bootstrapColSize' => 6],
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
            'nome_completo' => ['min:5', 'max:100'],
            'nome_escolhido' => ['min:2', 'max:50'],
            'genero_declarado_id' => ['numeric'],
            'email' => ['email'],
            'email_verified_at' => ['date'],
            'remember_token' => ['max:100'],
            'ativo' => ['boolean'],
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

    public function showMe(Request $request)
    {
        $id = $this->getCurrentUserId($request);
        if ($this->isApiRoute($request)) {
            $entity = $this->mainModel::findOrFail($id);
            return GlobalResource::jsonResponse(['entity' => $entity]);

        } else {
            $entity = $this->mainModel::with('generoDeclarado')->find($id);
            $generos = Genero::all();
            $params = [
                'jwt' => $request->cookie('jat'),
                'title' => 'Meu Perfil',
                'description' => '',
                'id' => $id,
                'url' => url('/users'),
                'apiUrl' => url('/api/users'),
                'entity' => $entity,
                'displayFields' => [
                    0 => ['name' => 'avatar_path', 'caption' => 'Avatar', 'inputType' => 'select', 'options' => $generos, 'id' => 'id', 'value' => 'genero', 'selected' => $entity->generoDeclarado->genero, 'bootstrapColSize' => 6 ],
                    1 => ['name' => 'nome_completo', 'caption' => 'Nome completo', 'inputType' => 'text', 'bootstrapColSize' => 6 ],
                    2 => ['name' => 'nome_escolhido', 'caption' => 'Nome', 'inputType' => 'text', 'bootstrapColSize' => 6 ],
                    3 => ['name' => 'ativo', 'caption' => 'Ativo', 'inputType' => 'select', 'options' => $generos, 'id' => 'id', 'value' => 'genero', 'selected' => $entity->generoDeclarado->genero, 'bootstrapColSize' => 3 ],
                    4 => ['name' => 'genero_declarado_id', 'caption' => 'Gênero', 'inputType' => 'select', 'options' => $generos, 'id' => 'id', 'value' => 'genero', 'selected' => $entity->generoDeclarado->genero, 'bootstrapColSize' => 6 ],
                    5 => ['name' => 'email', 'caption' => 'E-mail', 'inputType' => 'text', 'bootstrapColSize' => 6 ],
                ],
            ];
    
            return view('components.edit', $params);
        }
    }
}
