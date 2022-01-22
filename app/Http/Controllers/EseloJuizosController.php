<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloJuizo;
use App\Models\BizRules\EseloComarca;
use App\Models\BizRules\EspaiderJuizo;
use Illuminate\Http\Request;

class EseloJuizosController extends Controller
{
    protected $mainModel = 'App\Models\BizRules\EseloJuizo';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::with(["eseloComarca", "espaiderJuizo"])->get();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Juízos (redação do e-Selo)',
                'description' => 'Juízos existentes no e-Selo TJ/BA (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/eselo-juizos'),
                'apiUrl' => url('/api/eselo-juizos'),
                'dbFieldNames' => ["nome_juizo_eselo", "eselo_comarca.nome_comarca_eselo", "espaider_juizo.nome_juizo_espaider"],
                'dbNameField' => "nome_juizo_eselo",
                'dbIdField' => "id",
                'tableColumnNames' => ['Juízo (e-Selo)', 'Comarca (e-Selo)', 'Juízo (Espaider)']
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
            "nome_juizo_eselo" => ["required", "min:2", "max:150", "unique:eselo_juizos"],
            "eselo_comarca_id" => ["required", "numeric"],
            "espaider_juizo_id" => ["required", "numeric"]
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
                1 => ['name' => 'eselo_comarca_id', 'caption' => 'Comarca (e-Selo)', 'inputType' => 'select', 'options' => $eseloComarcas, 'id' => 'id', 'value' => 'nome_comarca_eselo', 'selected' => $entity->eseloComarca->nome_comarca_eselo ],
                2 => ['name' => 'espaider_juizo_id', 'caption' => 'Juízo (Espaider)', 'inputType' => 'select', 'options' => $espaiderJuizos, 'id' => 'id', 'value' => 'nome_juizo_espaider', 'selected' => $entity->espaiderJuizo->nome_juizo_espaider ]
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
        $validationRules = [
            "nome_juizo_eselo" => ["min:2", "max:150"],
            "eselo_comarca_id" => ["numeric"],
            "espaider_juizo_id" => ["numeric"]
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
        $eseloJuizos = $this->mainModel::with('eseloComarca')->whereBelongsTo($espaiderJuizo)->get();

        foreach ($eseloJuizos as $eseloJuizo) {
            $resp[] = [
                'eseloJuizo' => $eseloJuizo->nome_juizo_eselo,
                'comarca' => $eseloJuizo->eseloComarca->nome_comarca_eselo
            ];
        }

        return response()->json(["data" => $resp]);
    }
}
