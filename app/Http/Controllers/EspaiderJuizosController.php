<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderJuizo;
use Illuminate\Http\Request;

class EspaiderJuizosController extends Controller
{
    private $validationRules = [
        "nome_juizo_espaider" => ["required", "min:5", "max:120", "unique:espaider_juizos"],
        "redacao_cabecalho_juizo" => ["required", "max:150"],
        "redacao_resumida_juizo" => ["required", "max:60"],
        "espaider_comarca_id" => ["required", "numeric"],
        "espaider_orgao_id" => ["required", "numeric"]
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = EspaiderJuizo::with(["espaiderComarca", "espaiderOrgao"])->get();
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
        return $this->validateAndStore($request, EspaiderJuizo::class, $this->validationRules);
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
        return $this->validateAndUpdate($request, EspaiderJuizo::class, $id, $this->validationRules);
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
