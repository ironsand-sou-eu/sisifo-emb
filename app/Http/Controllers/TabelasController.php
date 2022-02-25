<?php

namespace App\Http\Controllers;

use App\Models\Access\Tabela;
use Illuminate\Http\Request;

class TabelasController extends Controller
{
    protected $mainModel = \App\Models\Access\Tabela::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Tabelas',
            'description' => 'Tabelas que compõem o banco de dados do Sísifo',
            'url' => url('/tabelas'),
            'apiUrl' => url('/api/tabelas'),
            'dbFieldNames' => ['nome_tabela'],
            'dbNameField' => 'nome_tabela',
            'dbIdField' => 'id',
            'tableColumnNames' => ['Tabela'],
        ];
        return $this->generalIndex($request, $params);
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
            'nome_tabela' => ['required', 'max:60', 'unique:tabelas'],
        ];

        return $this->validateAndStore($request, $this->mainModel, $validationRules);
    }

    /**
     * Open resource's creation form in frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\View
     */
    public function create(Request $request)
    {
        if ($this->isApiRoute($request)) {
            return response('', 404);
        }

        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Nova tabela (redação Sísifo)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/tabelas'),
            'apiUrl' => url('/api/tabelas'),
            'displayFields' => [
                0 => ['name' => 'nome_tabela', 'caption' => 'Nome da tabela', 'inputType' => 'text', 'bootstrapColSize' => 6],
            ],
        ];

        return view('components.new', $params);
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

        $entity = $this->mainModel::find($id);
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando tabela',
            'description' => '',
            'id' => $id,
            'url' => url('/tabelas'),
            'apiUrl' => url('/api/tabelas'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_tabela', 'caption' => 'Tabela', 'inputType' => 'text', 'bootstrapColSize' => 6],
            ],
        ];

        return view('components.edit', $params);
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
            'nome_tabela' => ['max:60'],
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
