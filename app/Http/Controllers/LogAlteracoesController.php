<?php

namespace App\Http\Controllers;

use App\Models\Access\LogAlteracao;
use Illuminate\Http\Request;

class LogAlteracoesController extends Controller
{
    protected $mainModel = \App\Models\Access\LogAlteracao::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Log de Alterações',
            'description' => '',
            'url' => url('/log-alteracoes'),
            'apiUrl' => url('/api/log-alteracoes'),
            'dbFieldNames' => [
                'campo.nome_exibicao',
                'campo.tabela.nome_exibicao',
                'valorAnterior',
                'valorAtual',
                'dataAlteracao',
                'alteradoPor.nome_escolhido'
            ],
            'dbNameField' => 'campo.nome_campo',
            'dbIdField' => 'id',
            'tableColumnNames' => [
                'Campo',
                'Tabela',
                'Valor anterior',
                'Valor atual',
                'Data da alteração',
                'Alterado por'
            ],
            'sortingColumnIndexBase0' => 4,
            'sortingDirection' => 'desc',
        ];
        return $this->generalIndex($request,
        $params);
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
            'campo_id' => ['required', 'numeric'],
            'valor_anterior' => ['required', 'max:150'],
            'valor_atual' => ['required', 'max:150'],
            'data_alteracao' => ['required', 'date'],
            'alterado_por' => ['required', 'numeric'],
        ];

        return $this->validateAndStore($request, $this->mainModel, $validationRules);
    }

    /**
     * Open resource's creation form in frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\View
     */
    public function create()
    {
        return response('', 404);
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
            'title' => 'Visualizando registro de alteração',
            'description' => '',
            'id' => $id,
            'url' => url('/log-alteracoes'),
            'apiUrl' => url('/api/log-alteracoes'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'valor_anterior', 'caption' => 'Valor original', 'inputType' => 'text'],
                1 => ['name' => 'valor_atual', 'caption' => 'Valor alterado', 'inputType' => 'text'],
                2 => ['name' => 'data_alteracao', 'caption' => 'Data da alteração', 'inputType' => 'datetime'],
            ],
        ];

        return view('components.edit', $params);
    }

    public function update(Request $request, $id)
    {
        return response('', 404);
    }

    public function destroy($id)
    {
        return response('', 404);
    }
}
