<?php

namespace App\Http\Controllers;

use App\Models\Access\Campo;
use Illuminate\Http\Request;
use App\Rules\UniqueCombinationRule;

class CamposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = Campo::all();
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
        $nomeCampo = $request->input("nome_campo");
        $validationRules = [
            "nome_campo" => ["required", "max:191"],
            "tabela_id" => ["required", "numeric", new UniqueCombinationRule(Campo::class, ['nome_campo', $nomeCampo])]
        ];

        return $this->validateAndStore($request, Campo::class, $validationRules);
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
        $nomeCampo = $request->input("nome_campo");
        $validationRules = [
            "nome_campo" => ["max:191"],
            "tabela_id" => ["numeric", new UniqueCombinationRule(Campo::class, ['nome_campo', $nomeCampo])]
        ];

        return $this->validateAndUpdate($request, Campo::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(Campo::class, $id);
    }
}
