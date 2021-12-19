<?php

namespace App\Http\Controllers;

use App\Models\Access\Campo;
use App\Models\Access\Tabela;
use Illuminate\Http\Request;

class CamposController extends Controller
{
    private $validationRules = [
        "nome_campo" => ["required", "max:191"],
        "tabela_id" => [
            "required", "numeric",
            function($attribute, $value, $fail) use ($nomeCampo) {
                if(Campo::where($attribute, $value)->where('nome_campo', $nomeCampo)->exists()) {
                    $nomeTabela = Tabela::find($value)->value("nome_tabela");
                    $fail("Já existe um campo chamado {$nomeCampo} na tabela {$nomeTabela}.");
                }
            }
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullList = Campo::all();
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
        $nomeCampo = $request->input("nome_campo");
        // $validationRules = [
        //     "nome_campo" => ["required", "max:191"],
        //     "tabela_id" => [
        //         "required", "numeric",
        //         function($attribute, $value, $fail) use ($nomeCampo) {
        //             if(Campo::where($attribute, $value)->where('nome_campo', $nomeCampo)->exists()) {
        //                 $nomeTabela = Tabela::find($value)->value("nome_tabela");
        //                 $fail("Já existe um campo chamado {$nomeCampo} na tabela {$nomeTabela}.");
        //             }
        //         }
        //     ]
        // ];

        return $this->validateAndStore($request, Campo::class, $this->validationRules);
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
        $nomeCampo = $request->input("nome_campo");

        return $this->validateAndUpdate($request, Campo::class, $id, $validationRules);
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
