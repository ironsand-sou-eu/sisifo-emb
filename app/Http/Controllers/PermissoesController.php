<?php

namespace App\Http\Controllers;

use App\Models\Access\Permissao;
use App\Rules\UniqueCombinationRule;
use Illuminate\Http\Request;

class PermissoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = Permissao::all(); #with(["user", "tabela", "tipoPermissao"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Permissões',
                'description' => 'Permissões dos usuários do Sísifo',
                'url' => url('/permissoes'),
                'apiUrl' => url('/api/permissoes'),
                'dbFieldNames' => ["user.nome_escolhido", "tabela.nome_tabela", "permissao.nome_permissao"],
                'dbNameField' => "user.nome_escolhido",
                'dbIdField' => "id",
                'tableColumnNames' => ['Usuário', 'Tabela', 'Permissão']
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
        $userId = $request->input("user_id");
        $validationRules = [
            "user_id" => ["required", "numeric"],
            "tipo_permissao_id" => ["required", "numeric"],
            "tabela_id" => ["required", "numeric", new UniqueCombinationRule(Permissao::class, "user_id", $userId)]
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
        $entity = Permissao::findOrFail($id);
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
        $userId = $request->input("user_id");
        $validationRules = [
            "user_id" => ["numeric"],
            "tipo_permissao_id" => ["numeric"],
            "tabela_id" => ["numeric", new UniqueCombinationRule(Permissao::class, "user_id", $userId)]
        ];
        return $this->validateAndUpdate($request, Permissao::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(Permissao::class, $id);
    }
}
