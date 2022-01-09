<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderJuizo;
use Illuminate\Http\Request;

class EspaiderJuizosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = EspaiderJuizo::with(["espaiderComarca", "espaiderOrgao"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Juízos (redação do Espaider)',
                'description' => 'Juízos existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/espaider-juizos'),
                'apiUrl' => url('/api/espaider-juizos'),
                'dbFieldNames' => ["nome_juizo_espaider", "redacao_cabecalho_juizo", "redacao_resumida_juizo", "espaider_comarca.nome_comarca_espaider", "espaider_orgao.sigla_orgao"],
                'dbNameField' => "nome_juizo_espaider",
                'dbIdField' => "id",
                'tableColumnNames' => ['Juízo (Espaider)', 'Redação para cabeçalho de peças', 'Redação resumida para peças', 'Comarca (Espaider)', 'Órgão (Espaider)']
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
            "nome_juizo_espaider" => ["required", "min:5", "max:120", "unique:espaider_juizos"],
            "redacao_cabecalho_juizo" => ["required", "max:150"],
            "redacao_resumida_juizo" => ["required", "max:60"],
            "espaider_comarca_id" => ["required", "numeric"],
            "espaider_orgao_id" => ["required", "numeric"]
        ];
        return $this->validateAndStore($request, EspaiderJuizo::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = EspaiderJuizo::with(["espaiderComarca", "espaiderOrgao"])->findOrFail($id);
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
            "nome_juizo_espaider" => ["min:5", "max:120", "unique:espaider_juizos"],
            "redacao_cabecalho_juizo" => ["max:150"],
            "redacao_resumida_juizo" => ["max:60"],
            "espaider_comarca_id" => ["numeric"],
            "espaider_orgao_id" => ["numeric"]
        ];
        return $this->validateAndUpdate($request, EspaiderJuizo::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(EspaiderJuizo::class, $id);
    }
}
