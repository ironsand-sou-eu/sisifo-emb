<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloConfig;
use Illuminate\Http\Request;

class EseloConfigsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = EseloConfig::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Configurações - Sísifo DAJEs',
                'description' => 'Configurações necessárias para a geração dos dados pelo Sísifo DAJEs',
                'url' => url('/eselo-configs'),
                'apiUrl' => url('/api/eselo-configs'),
                'dbFieldNames' => ["nome", "valor"],
                'dbNameField' => "nome",
                'dbIdField' => "id",
                'tableColumnNames' => ['Nome', "Valor da configuração"]
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
            "nome" => ["required", "max:50", "unique:nome"],
            "valor" => ["required"],
        ];    
        return $this->validateAndStore($request, EseloConfig::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = EseloConfig::findOrFail($id);
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
            "nome" => ["required", "max:50", "unique:nome"],
            "valor" => ["required"],
        ];    
        return $this->validateAndUpdate($request, EseloConfig::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(EseloConfig::class, $id);
    }
}
