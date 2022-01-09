<?php

namespace App\Http\Controllers;

use App\Models\Access\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = User::with(["generoDeclarado"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Usuários',
                'description' => 'Usuários do Sísifo',
                'url' => url('/users'),
                'apiUrl' => url('/api/users'),
                'dbFieldNames' => ["nome_escolhido", "nome_completo", "email", "genero_declarado.genero", "ativo"],
                'dbNameField' => "nome_escolhido",
                'dbIdField' => "id",
                'tableColumnNames' => ['Nome', 'Nome completo', 'E-mail', 'Gênero', 'Ativo']
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
            "nome_completo" => ["required", "min:5", "max:100"],
            "nome_escolhido" => ["nullable", "min:2", "max:50"],
            "genero_declarado_id" => ["required", "numeric"],
            "email" => ["required", "email", "unique:users"],
            "email_verified_at" => ["nullable", "date"],
            "password" => ["required"],
            "remember_token" => ["nullable", "max:100"],
            "ativo" => ["required", "boolean"],
            "avatar_path" => ["nullable"]
        ];
        return $this->validateAndStore($request, User::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = User::with(["generoDeclarado"])->findOrFail($id);
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
            "nome_completo" => ["min:5", "max:100"],
            "nome_escolhido" => ["min:2", "max:50"],
            "genero_declarado_id" => ["numeric"],
            "email" => ["email", "unique:users"],
            "email_verified_at" => ["date"],
            "remember_token" => ["max:100"],
            "ativo" => ["boolean"]
        ];
        return $this->validateAndUpdate($request, User::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(User::class, $id);
    }
}
