<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloComarca;
use Illuminate\Http\Request;

class EseloComarcasController extends Controller
{
    protected $mainModel = \App\Models\BizRules\EseloComarca::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Comarcas (redação do e-Selo)',
            'description' => 'Comarcas existentes no e-Selo TJ/BA (a redação deve ser idêntica à daquele sistema).',
            'url' => url('/eselo-comarcas'),
            'apiUrl' => url('/api/eselo-comarcas'),
            'dbFieldNames' => ['nome'],
            'dbNameField' => 'nome',
            'dbIdField' => 'id',
            'tableColumnNames' => ['Comarca (e-Selo)'],
        ];
        return $this->generalIndex($request, $params);
    }
        
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'nome_comarca_eselo' => ['required', 'min:2', 'max:40', 'unique:eselo_comarcas'],
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
            'title' => 'Nova comarca (redação e-Selo)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'url' => url('/eselo-comarcas'),
            'apiUrl' => url('/api/eselo-comarcas'),
            'displayFields' => [
                0 => ['name' => 'nome_comarca_eselo', 'caption' => 'Comarca (e-Selo)', 'inputType' => 'text', 'bootstrapColSize' => 6],
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
            'title' => 'Editando comarca (redação e-Selo)',
            'description' => 'O nome deve estar escrito exatamente como está registrado naquele sistema.',
            'id' => $id,
            'url' => url('/eselo-comarcas'),
            'apiUrl' => url('/api/eselo-comarcas'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_comarca_eselo', 'caption' => 'Comarca (e-Selo)', 'inputType' => 'text', 'bootstrapColSize' => 6],
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
            'nome_comarca_eselo' => ['min:2', 'max:40'],
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
