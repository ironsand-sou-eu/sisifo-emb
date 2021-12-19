<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderUf;
use Illuminate\Http\Request;

class EspaiderUfsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = EspaiderUf::all();
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
            "nome_uf_espaider" => ["required", "min:4", "max:25", "unique:espaider_ufs"],
            "sigla" => ["required", "regex:/^[A-Z]{2}$/", "unique:espaider_ufs"],
        ];
        return $this->validateAndStore($request, EspaiderUf::class, $validationRules);
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
        $validationRules = [
            "nome_uf_espaider" => ["min:4", "max:25", "unique:espaider_ufs"],
            "sigla" => ["regex:/^[A-Z]{2}$/", "unique:espaider_ufs"],
        ];
        return $this->validateAndUpdate($request, EspaiderUf::class, $id, $validationRules);
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
