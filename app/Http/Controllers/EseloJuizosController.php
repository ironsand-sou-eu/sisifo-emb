<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloComarca;
use App\Models\BizRules\EseloJuizo;
use App\Models\BizRules\EspaiderJuizo;
use App\Rules\UniqueCombinationRule;
use Illuminate\Http\Request;
use App\Http\Resources\GlobalResource;

class EseloJuizosController extends Controller
{
    protected $mainModel = \App\Models\BizRules\EseloJuizo::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Juízos (redação do e-Selo)',
            'description' => 'Juízos existentes no e-Selo TJ/BA (a redação deve ser idêntica à daquele sistema).',
            'url' => url('/eselo-juizos'),
            'apiUrl' => url('/api/eselo-juizos'),
            'dbFieldNames' => [
                'nome',
                'eseloComarca.nome_comarca_eselo',
                'espaiderJuizo.nome_juizo_espaider'
            ],
            'dbNameField' => 'nome',
            'dbIdField' => 'id',
            'tableColumnNames' => [
                'Juízo (e-Selo)',
                'Comarca (e-Selo)',
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
            'nome_juizo_eselo' => ['required', 'min:2', 'max:150', new UniqueCombinationRule($this->mainModel, ['espaider_juizo_id', $request->input('espaider_juizo_id')])],
            'eselo_comarca_id' => ['required', 'numeric'],
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

        $eseloComarcas = EseloComarca::all();
        $espaiderJuizos = EspaiderJuizo::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Novo juízo (redação e-Selo)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/eselo-juizos'),
            'apiUrl' => url('/api/eselo-juizos'),
            'displayFields' => [
                0 => ['name' => 'nome_juizo_eselo', 'caption' => 'Juízo (e-Selo)', 'inputType' => 'text'],
                1 => ['name' => 'eselo_comarca_id', 'caption' => 'Comarca (e-Selo)', 'inputType' => 'select', 'options' => $eseloComarcas, 'id' => 'id', 'value' => 'nome_comarca_eselo', 'bootstrapColSize' => 6],
                2 => ['name' => 'espaider_juizo_id', 'caption' => 'Juízo (Espaider)', 'inputType' => 'select', 'options' => $espaiderJuizos, 'id' => 'id', 'value' => 'nome_juizo_espaider', 'bootstrapColSize' => 6],
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

        $entity = $this->mainModel::with(['eseloComarca', 'espaiderJuizo'])->find($id);
        $eseloComarcas = EseloComarca::all();
        $espaiderJuizos = EspaiderJuizo::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando juízos (redação e-Selo)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'id' => $id,
            'url' => url('/eselo-juizos'),
            'apiUrl' => url('/api/eselo-juizos'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_juizo_eselo', 'caption' => 'Juízo (e-Selo)', 'inputType' => 'text'],
                1 => ['name' => 'eselo_comarca_id', 'caption' => 'Comarca (e-Selo)', 'inputType' => 'select', 'options' => $eseloComarcas, 'id' => 'id', 'value' => 'nome_comarca_eselo', 'selected' => $entity->eseloComarca->nome_comarca_eselo, 'bootstrapColSize' => 6],
                2 => ['name' => 'espaider_juizo_id', 'caption' => 'Juízo (Espaider)', 'inputType' => 'select', 'options' => $espaiderJuizos, 'id' => 'id', 'value' => 'nome_juizo_espaider', 'selected' => $entity->espaiderJuizo->nome_juizo_espaider, 'bootstrapColSize' => 6],
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
            'nome_juizo_eselo' => ['min:2', 'max:150'],
            'eselo_comarca_id' => ['numeric'],
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

    /**
     * Get e-Selo's juízo and comarca from espaider's juízo slug
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function getEseloInfoFromEspaiderJuizoSlug($slug)
    {
        $espaiderJuizo = EspaiderJuizo::where('slug', $slug)->first();
        if (!$espaiderJuizo)
            return GlobalResource::jsonResponse(['resp' => __('db.notFound')], 404);

        $eseloJuizos = $this->mainModel::with('eseloComarca')
                        ->whereBelongsTo($espaiderJuizo)
                        ->get();
        
        if ($eseloJuizos->count() === 0)
            return GlobalResource::jsonResponse(['resp' => __('db.notFound')], 404);

        foreach ($eseloJuizos as $eseloJuizo) {
            $resp[] = [
                'eseloJuizo' => $eseloJuizo->nome_juizo_eselo,
                'eseloComarca' => $eseloJuizo->eseloComarca->nome_comarca_eselo,
            ];
        }

        return GlobalResource::jsonResponse(['data' => $resp], 200);
    }
}
