<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderJuizo;
use App\Models\BizRules\SistemasJudJuizo;
use Illuminate\Http\Request;

class SistemasJudJuizosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = SistemasJudJuizo::with(["espaiderJuizo"])->get();
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
            "nome_juizo_sistemas_jud" => ["required", "max:120", "unique:sistemas_jud_juizos"],
            "espaider_juizo_id" => ["required", "numeric"]
        ];
        return $this->validateAndStore($request, SistemasJudJuizo::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = SistemasJudJuizo::findOrFail($id);
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
            "nome_juizo_sistemas_jud" => ["max:120", "unique:sistemas_jud_juizos"],
            "espaider_juizo_id" => ["numeric"]
        ];
        return $this->validateAndUpdate($request, SistemasJudJuizo::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(SistemasJudJuizo::class, $id);
    }
}
