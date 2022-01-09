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
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = SistemasJudJuizo::with(["espaiderJuizo"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Juízos (Sistemas do Judiciário)',
                'description' => 'Juízos existentes nos sistemas processuais do Judiciário (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/sistemas-jud-juizos'),
                'apiUrl' => url('/api/sistemas-jud-juizos'),
                'dbFieldNames' => ["nome_juizo_sistemas_jud", "espaider_juizo.nome_juizo_espaider"],
                'dbNameField' => "nome_juizo_sistemas_jud",
                'dbIdField' => "id",
                'tableColumnNames' => ['Juízo (sistemas processuais do Judiciário)', 'Juízo (Espaider)']
            ]);
        }
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
        $entity = SistemasJudJuizo::with(["espaiderJuizo"])->findOrFail($id);
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
