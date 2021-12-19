<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloJuizo;
use Illuminate\Http\Request;

class EseloJuizosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = EseloJuizo::with(["eseloComarca", "espaiderJuizo"])->get();
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
            "nome_juizo_eselo" => ["required", "min:2", "max:150", "unique:eselo_juizos"],
            "eselo_comarca_id" => ["required", "numeric"],
            "espaider_juizo_id" => ["required", "numeric"]
        ];
        return $this->validateAndStore($request, EseloJuizo::class, $validationRules);
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
            "nome_juizo_eselo" => ["min:2", "max:150", "unique:eselo_juizos"],
            "eselo_comarca_id" => ["numeric"],
            "espaider_juizo_id" => ["numeric"]
        ];
        return $this->validateAndUpdate($request, EseloJuizo::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(EseloJuizo::class, $id);
    }
}
