<?php

namespace App\Http\Controllers;

use App\Models\Access\LogAlteracao;
use Illuminate\Http\Request;

class LogAlteracoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = LogAlteracao::all();
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
        $validationRules = [
            "campo_id" => ["required", "numeric"],
            "valor_anterior" => ["required", "max:150"],
            "valor_atual" => ["required", "max:150"],
            "data_alteracao" => ["required", "date"],
            "alterado_por" => ["required", "numeric"]
        ];
        return $this->validateAndStore($request, LogAlteracao::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = LogAlteracao::findOrFail($id);
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
            "campo_id" => ["numeric"],
            "valor_anterior" => ["max:150"],
            "valor_atual" => ["max:150"],
            "data_alteracao" => ["date"],
            "alterado_por" => ["numeric"]
        ];
        return $this->validateAndUpdate($request, LogAlteracao::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(LogAlteracao::class, $id);
    }
}
