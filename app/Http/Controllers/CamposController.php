<?php

namespace App\Http\Controllers;

use App\Models\Access\Campo;
use App\Models\Access\Tabela;
use Illuminate\Http\Request;
use App\Rules\UniqueCombinationRule;

class CamposController extends Controller
{
    protected $mainModel = 'App\Models\Access\Campo';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::with(["tabela"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Campos',
                'description' => 'Campos que compõem as tabelas do Sísifo',
                'url' => url('/campos'),
                'apiUrl' => url('/api/campos'),
                'dbFieldNames' => ["nome_campo", "tabela.nome_tabela"],
                'dbNameField' => "nome_campo",
                'dbIdField' => "id",
                'tableColumnNames' => ['Campo', 'Tabela']
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
        $nomeCampo = $request->input("nome_campo");
        $validationRules = [
            "nome_campo" => ["required", "max:191"],
            "tabela_id" => ["required", "numeric", new UniqueCombinationRule($this->mainModel, ['nome_campo', $nomeCampo])]
        ];

        return $this->validateAndStore($request, $this->mainModel, $validationRules);
    }

        /**
     * Open the specified resource for edition in frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit(Request $request, $id)
    {
        if ($this->isApiRoute($request)) {
            return response('', 404);
        }

        $entity = $this->mainModel::with('tabelas')->find($id);
        $tabelas = Tabela::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando campo',
            'description' => '',
            'id' => $id,
            'url' => url('/campos'),
            'apiUrl' => url('/api/campos'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_campo', 'caption' => 'Nome do campo', 'inputType' => 'text'],
                1 => ['name' => 'tabela_id', 'caption' => 'Tabela', 'inputType' => 'select', 'options' => $tabelas, 'id' => 'id', 'value' => 'nome_tabela', 'selected' => $entity->tabela->nome_tabela ]
            ]
        ];

        return view("components.edit", $params);
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
        $validationRules = [
            "nome_campo" => ["max:191"],
            "tabela_id" => ["numeric", new UniqueCombinationRule($this->mainModel, ['nome_campo', $nomeCampo])]
        ];

        return $this->validateAndUpdate($request, $this->mainModel, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete($this->mainModel, $id);
    }
}
