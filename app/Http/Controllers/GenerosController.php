<?php

namespace App\Http\Controllers;

use App\Models\Access\Genero;
use Illuminate\Http\Request;

class GenerosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = Genero::all();
            return response()->json(["fullList" => $fullList]);
        } else {
            $jwt = $request->cookie('jat');
            return view("components.index", [
                'jwt' => $jwt,
                'title' => 'Gêneros',
                'description' => 'Gêneros dos usuários',
                'url' => url('/generos'),
                'apiUrl' => url('/api/generos'),
                'dbFieldNames' => ["genero"],
                'dbNameField' => "genero",
                'dbIdField' => "id",
                'tableColumnNames' => ['Gênero']
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
            "genero" => ["required", "max:20", "unique:generos"],
        ];    
        return $this->validateAndStore($request, Genero::class, $validationRules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = Genero::findOrFail($id);
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
            "genero" => ["max:20", "unique:generos"],
        ];    
        return $this->validateAndUpdate($request, Genero::class, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete(Genero::class, $id);
    }
}
