<?php

namespace App\Http\Controllers;

use App\Models\Access\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $validationRules = [
        "nome_completo" => ["required", "min:5", "max:100"],
        "nome_escolhido" => ["nullable", "min:2", "max:50"],
        "genero_declarado_id" => ["required", "numeric"],
        "email" => ["required", "email", "unique:users"],
        "email_verified_at" => ["nullable", "date"],
        "password" => ["required"],
        "remember_token" => ["nullable", "max:100"],
        "ativo" => ["required", "boolean"]
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = User::with(["genero_declarado"])->get();
        return response()->json(["fullList" => $fullList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->validateAndStore($request, User::class, $this->validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return $this->validateAndUpdate($request, User::class, $id, $this->validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
