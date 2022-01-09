<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderOrgao;
use Illuminate\Http\Request;

class EspaiderOrgaosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = EspaiderOrgao::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Órgãos',
                'description' => 'Juízos existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/espaider-orgaos'),
                'apiUrl' => url('/api/espaider-orgaos'),
                'dbFieldNames' => ["nome_orgao_espaider", "sigla_orgao"],
                'dbNameField' => "nome_orgao_espaider",
                'dbIdField' => "id",
                'tableColumnNames' => ['Órgão (Espaider)', 'Sigla']
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
            "nome_orgao_espaider" => ["required", "min:3", "max:90", "unique:espaider_orgaos"],
            "sigla_orgao" => ["required", "min:2", "max:25"],
        ];
        return $this->validateAndStore($request, EspaiderOrgao::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = EspaiderOrgao::findOrFail($id);
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
            "nome_orgao_espaider" => ["required", "min:3", "max:90", "unique:espaider_orgaos"],
            "sigla_orgao" => ["required", "min:2", "max:25"],
        ];
        return $this->validateAndUpdate($request, EspaiderOrgao::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(EspaiderOrgao::class, $id);
    }
}
