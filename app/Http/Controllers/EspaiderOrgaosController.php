<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderOrgao;
use Illuminate\Http\Request;

class EspaiderOrgaosController extends Controller
{
    private $validationRules = [
        "nome_orgao_espaider" => ["required", "min:3", "max:90", "unique:espaider_orgaos"],
        "sigla_orgao" => ["required", "min:2", "max:25"],
    ];
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = EspaiderOrgao::all();
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
        return $this->validateAndStore($request, EspaiderOrgao::class, $this->validationRules);
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
        return $this->validateAndUpdate($request, EspaiderOrgao::class, $id, $this->validationRules);
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
