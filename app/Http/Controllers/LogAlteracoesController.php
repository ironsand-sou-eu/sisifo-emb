<?php

namespace App\Http\Controllers;

use App\Models\Access\LogAlteracao;
use Illuminate\Http\Request;

class LogAlteracoesController extends Controller
{
    private $validationRules = [
        "campo_id" => ["required", "numeric"],
        "valor_anterior" => ["required", "max:150"],
        "valor_atual" => ["required", "max:150"],
        "data_alteracao" => ["required", "date"],
        "alterado_por" => ["required", "numeric"]
    ];

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
        return $this->validateAndStore($request, LogAlteracao::class, $this->validationRules);
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
        return $this->validateAndUpdate($request, LogAlteracao::class, $id, $this->validationRules);
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
