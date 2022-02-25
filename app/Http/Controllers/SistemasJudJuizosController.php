<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderJuizo;
use App\Models\BizRules\SistemasJudJuizo;
use Illuminate\Http\Request;

class SistemasJudJuizosController extends Controller
{
    protected $mainModel = \App\Models\BizRules\SistemasJudJuizo::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Juízos (Sistemas do Judiciário)',
            'description' => 'Juízos existentes nos sistemas processuais do Judiciário (a redação deve ser idêntica à daquele sistema).',
            'url' => url('/sistemas-jud-juizos'),
            'apiUrl' => url('/api/sistemas-jud-juizos'),
            'dbFieldNames' => [
                'nome',
                'espaiderJuizo.nome_juizo_espaider'
            ],
            'dbNameField' => 'nome',
            'dbIdField' => 'id',
            'tableColumnNames' => [
                'Juízo (sistemas processuais do Judiciário)',
                'Juízo (Espaider)'
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
            'nome_juizo_sistemas_jud' => ['required', 'max:120', 'unique:sistemas_jud_juizos'],
            'espaider_juizo_id' => ['required', 'numeric'],
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

        $espaiderJuizos = EspaiderJuizo::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Novo juízo (redação de outros sistemas)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/sistemas-jud-juizos'),
            'apiUrl' => url('/api/sistemas-jud-juizo'),
            'displayFields' => [
                0 => ['name' => 'nome_juizo_sistemas_jud', 'caption' => 'Juízo (outros sistemas)', 'inputType' => 'text'],
                1 => ['name' => 'espaider_juizo_id', 'caption' => 'Juízo (Espaider)', 'inputType' => 'select', 'options' => $espaiderJuizos, 'id' => 'id', 'value' => 'nome_juizo_espaider'],
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

        $entity = $this->mainModel::with('espaiderJuizo')->find($id);
        $espaiderJuizos = EspaiderJuizo::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando juízos (Sistemas do Judiciário)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'id' => $id,
            'url' => url('/sistemas-jud-juizos'),
            'apiUrl' => url('/api/sistemas-jud-juizos'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_juizo_sistemas_jud', 'caption' => 'Juízo (sistema do Judiciário)', 'inputType' => 'text'],
                1 => ['name' => 'espaider_juizo_id', 'caption' => 'Juízo (Espaider)', 'inputType' => 'select', 'options' => $espaiderJuizos, 'id' => 'id', 'value' => 'nome_juizo_espaider', 'selected' => $entity->espaiderJuizo->nome_juizo_espaider],
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
            'nome_juizo_sistemas_jud' => ['max:120'],
            'espaider_juizo_id' => ['numeric'],
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
