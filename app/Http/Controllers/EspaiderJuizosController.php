<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderComarca;
use App\Models\BizRules\EspaiderJuizo;
use App\Models\BizRules\EspaiderOrgao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EspaiderJuizosController extends Controller
{
    protected $mainModel = \App\Models\BizRules\EspaiderJuizo::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Juízos (redação do Espaider)',
            'description' => 'Juízos existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
            'url' => url('/espaider-juizos'),
            'apiUrl' => url('/api/espaider-juizos'),
            'dbFieldNames' => [
                'nome',
                'redacaoCabecalhoJuizo',
                'redacaoResumidaJuizo',
                'espaiderComarca.nome_comarca_espaider',
                'espaiderOrgao.sigla_orgao'
            ],
            'dbNameField' => 'nome',
            'dbIdField' => 'id',
            'tableColumnNames' => [
                'Juízo (Espaider)',
                'Redação para cabeçalho de peças',
                'Redação resumida para peças',
                'Comarca (Espaider)',
                'Órgão (Espaider)'
            ],
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
            'nome_juizo_espaider' => ['required', 'min:5', 'max:120', 'unique:espaider_juizos'],
            'redacao_cabecalho_juizo' => ['required', 'max:150'],
            'slug' => ['required', 'string'],
            'redacao_resumida_juizo' => ['required', 'max:60'],
            'espaider_comarca_id' => ['required', 'numeric'],
            'espaider_orgao_id' => ['required', 'numeric'],
        ];

        $slug = Str::slug($request->input('nome_juizo_espaider'));
        $request->mergeIfMissing(['slug' => $slug]);
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

        $espaiderComarcas = EspaiderComarca::all();
        $espaiderOrgaos = EspaiderOrgao::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Novo juízo (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/espaider-juizos'),
            'apiUrl' => url('/api/espaider-juizos'),
            'displayFields' => [
                0 => ['name' => 'nome_juizo_espaider', 'caption' => 'Nome do juízo (Espaider)', 'inputType' => 'text'],
                1 => ['name' => 'redacao_cabecalho_juizo', 'caption' => 'Texto de cabeçalho de peças', 'inputType' => 'text'],
                2 => ['name' => 'redacao_resumida_juizo', 'caption' => 'Texto resumido para peças', 'inputType' => 'text'],
                3 => ['name' => 'espaider_comarca_id', 'caption' => 'Comarca (Espaider)', 'inputType' => 'select', 'options' => $espaiderComarcas, 'id' => 'id', 'value' => 'nome_comarca_espaider', 'bootstrapColSize' => 6],
                4 => ['name' => 'espaider_orgao_id', 'caption' => 'Órgão (Espaider)', 'inputType' => 'select', 'options' => $espaiderOrgaos, 'id' => 'id', 'value' => 'nome_orgao_espaider', 'bootstrapColSize' => 6],
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
        $entity = $this->mainModel::with(['espaiderComarca', 'espaiderOrgao'])->find($id);
        $espaiderComarcas = EspaiderComarca::all();
        $espaiderOrgaos = EspaiderOrgao::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando juízo (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'id' => $id,
            'url' => url('/espaider-juizos'),
            'apiUrl' => url('/api/espaider-juizos'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_juizo_espaider', 'caption' => 'Nome do juízo (Espaider)', 'inputType' => 'text'],
                1 => ['name' => 'redacao_cabecalho_juizo', 'caption' => 'Texto de cabeçalho de peças', 'inputType' => 'text'],
                2 => ['name' => 'redacao_resumida_juizo', 'caption' => 'Texto resumido para peças', 'inputType' => 'text'],
                3 => ['name' => 'slug', 'caption' => 'Slug (uso interno do sistema)', 'inputType' => 'text'],
                4 => ['name' => 'espaiderComarca', 'caption' => 'Comarca (Espaider)', 'inputType' => 'select', 'options' => $espaiderComarcas, 'id' => 'id', 'value' => 'nome_comarca_espaider', 'selected' => $entity->espaiderComarca->nome_comarca_espaider, 'bootstrapColSize' => 6],
                5 => ['name' => 'espaiderOrgao', 'caption' => 'Órgão (Espaider)', 'inputType' => 'select', 'options' => $espaiderOrgaos, 'id' => 'id', 'value' => 'nome_orgao_espaider', 'selected' => $entity->espaiderOrgao->nome_orgao_espaider, 'bootstrapColSize' => 6],
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
            'nome_juizo_espaider' => ['min:5', 'max:120'],
            'redacao_cabecalho_juizo' => ['max:150'],
            'redacao_resumida_juizo' => ['max:60'],
            'slug' => ['string'],
            'espaider_comarca_id' => ['numeric'],
            'espaider_orgao_id' => ['numeric'],
        ];
        
        $slug = Str::slug($request->input('nome_juizo_espaider'));
        $request->merge(['slug' => $slug]);
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
