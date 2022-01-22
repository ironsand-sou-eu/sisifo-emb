<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EspaiderUf;
use Illuminate\Http\Request;

class EspaiderUfsController extends Controller
{
    protected $mainModel = 'App\Models\BizRules\EspaiderUf';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'UFs',
                'description' => 'Unidades da Federação existentes no Espaider (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/espaider-ufs'),
                'apiUrl' => url('/api/espaider-ufs'),
                'dbFieldNames' => ["nome_uf_espaider", "sigla"],
                'dbNameField' => "nome_uf_espaider",
                'dbIdField' => "sigla",
                'tableColumnNames' => ['UF', 'Sigla']
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
            "nome_uf_espaider" => ["required", "min:4", "max:25", "unique:espaider_ufs"],
            "sigla" => ["required", "regex:/^[A-Z]{2}$/", "unique:espaider_ufs"],
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

        $entity = $this->mainModel::find($id);
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando UF (redação do Espaider)',
            'description' => 'Unidades da Federação',
            'id' => $id,
            'url' => url('/espaider-ufs'),
            'apiUrl' => url('/api/espaider-ufs'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'nome_uf_espaider', 'caption' => 'Nome', 'inputType' => 'text'],
                0 => ['name' => 'sigla', 'caption' => 'Sigla', 'inputType' => 'text']
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
            "nome_uf_espaider" => ["min:4", "max:25"],
            "sigla" => ["regex:/^[A-Z]{2}$/"],
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
