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
