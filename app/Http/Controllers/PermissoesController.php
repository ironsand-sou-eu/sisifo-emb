<?php

namespace App\Http\Controllers;

use App\Models\Access\Permissao;
use App\Models\Access\Tabela;
use App\Models\Access\User;
use Illuminate\Http\Request;

class PermissoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = Permissao::all();
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
        $user = User::find($request->input("user_id"));
        $validationRules = [
            "user_id" => ["required", "numeric"],
            "tipo_permissao_id" => ["required", "numeric"],
            "tabela_id" => [
                "required", "numeric",
                function($attribute, $value, $fail) use ($user) {
                    if(Permissao::where($attribute, $value)->where('user_id', $user->id)->exists()) {
                        $nomeTabela = Tabela::find($value)->value("nome_tabela");
                        $fail("O usuário {$user->nome_escolhido} já tem permissões definidas para a tabela {$nomeTabela}.");
                    }
                }
            ]
        ];

        return $this->validateAndStore($request, Permissao::class, $validationRules);
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
        //
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
