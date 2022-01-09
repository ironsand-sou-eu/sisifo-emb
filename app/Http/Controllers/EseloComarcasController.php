<?php

namespace App\Http\Controllers;

use App\Models\BizRules\EseloComarca;
use Illuminate\Http\Request;

class EseloComarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = EseloComarca::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Comarcas (redação do e-Selo)',
                'description' => 'Comarcas existentes no e-Selo TJ/BA (a redação deve ser idêntica à daquele sistema).',
                'url' => url('/eselo-comarcas'),
                'apiUrl' => url('/api/eselo-comarcas'),
                'dbFieldNames' => ["nome_comarca_eselo"],
                'dbNameField' => "nome_comarca_eselo",
                'dbIdField' => "id",
                'tableColumnNames' => ['Comarca (e-Selo)']
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
            "nome_comarca_eselo" => ["required", "min:2", "max:40", "unique:eselo_comarcas"]
        ];
        return $this->validateAndStore($request, EseloComarca::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = EseloComarca::findOrFail($id);
        return response()->json(["entity" => $entity]);
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
            "nome_comarca_eselo" => ["min:2", "max:40", "unique:eselo_comarcas"]
        ];
        return $this->validateAndUpdate($request, EseloComarca::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(EseloComarca::class, $id);
    }
}
