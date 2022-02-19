<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderComarca;
use App\Models\BizRules\EspaiderUf;
use App\Rules\UniqueCombinationRule;
use Illuminate\Http\Request;

class EspaiderComarcasController extends Controller
{
    protected $mainModel = \App\Models\BizRules\EspaiderComarca::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::with(['espaiderUf'])->get();

            return response()->json(['fullList' => $fullList]);
        } else {
            $jwt = $request->cookie('jat');

            return view('components.index', [
                'jwt' => $jwt,
                'title' => 'Comarcas (redação do Espaider)',
                'description' => 'Comarcas existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/espaider-comarcas'),
                'apiUrl' => url('/api/espaider-comarcas'),
                'dbFieldNames' => ['nome_comarca_espaider', 'espaider_uf.sigla'],
                'dbNameField' => 'nome_comarca_espaider',
                'dbIdField' => 'id',
                'tableColumnNames' => ['Comarca (Espaider)', 'UF'],
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
        $nomeComarca = $request->input('nome_comarca_espaider');
        $validationRules = [
            'nome_comarca_espaider' => ['required', 'min:2', 'max:40'],
            'espaider_uf_id' => ['required', 'size:2', new UniqueCombinationRule(EspaiderComarca::class, ['nome_comarca_espaider', $nomeComarca])],
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

        $espaiderUfs = EspaiderUf::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Nova comarca (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/espaider-comarcas'),
            'apiUrl' => url('/api/espaider-comarcas'),
            'displayFields' => [
                0 => ['name' => 'nome_comarca_espaider', 'caption' => 'Comarca (Espaider)', 'inputType' => 'text'],
                1 => ['name' => 'eselo_comarca_id', 'caption' => 'Comarca (e-Selo)', 'inputType' => 'select', 'options' => $espaiderUfs, 'id' => 'sigla', 'value' => 'nome_uf_espaider'],
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

        $entity = $this->mainModel::with('espaiderUf')->find($id);
        $espaiderUfs = EspaiderUf::all();
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando comarca (redação Espaider)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'id' => $id,
            'url' => url('/espaider-comarcas'),
            'apiUrl' => url('/api/espaider-comarcas'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_comarca_espaider', 'caption' => 'Comarca (Espaider)', 'inputType' => 'text'],
                1 => ['name' => 'espaider_uf_id', 'caption' => 'Unidade da Federação', 'inputType' => 'select', 'options' => $espaiderUfs, 'id' => 'sigla', 'value' => 'nome_uf_espaider', 'selected' => $entity->espaiderUf->nome_uf_espaider],
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
        $nomeComarca = $request->input('nome_comarca_espaider');
        $validationRules = [
            'nome_comarca_espaider' => ['min:2', 'max:40'],
            'espaider_uf_id' => ['size:2', new UniqueCombinationRule(EspaiderComarca::class, ['nome_comarca_espaider', $nomeComarca])],
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
