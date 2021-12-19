<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloJuizo;
use Illuminate\Http\Request;

class EseloJuizosController extends Controller
{
    private $validationRules = [
        "nome_juizo_eselo" => ["required", "min:2", "max:150", "unique:eselo_juizos"],
        "eselo_comarca_id" => ["required", "numeric"],
        "espaider_juizo_id" => ["required", "numeric"]
    ];


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
        return $this->validateAndStore($request, EseloJuizo::class, $this->validationRules);
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
        return $this->validateAndUpdate($request, EseloJuizo::class, $id, $this->validationRules);
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
