<?php

namespace App\Http\Controllers;

use App\Models\Access\Genero;
use Illuminate\Http\Request;

class GenerosController extends Controller
{
    protected $mainModel = 'App\Models\Access\Genero';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->isApiRoute($request)) {
            $fullList = $this->mainModel::all();

            return response()->json(['fullList' => $fullList]);
        } else {
            $jwt = $request->cookie('jat');

            return view('components.index', [
                'jwt' => $jwt,
                'title' => 'Gêneros',
                'description' => 'Gêneros dos usuários',
                'url' => url('/generos'),
                'apiUrl' => url('/api/generos'),
                'dbFieldNames' => ['genero'],
                'dbNameField' => 'genero',
                'dbIdField' => 'id',
                'tableColumnNames' => ['Gênero'],
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
            'genero' => ['required', 'max:20', 'unique:generos'],
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
            'title' => 'Novo gênero',
            'description' => '',
            'url' => url('/generos'),
            'apiUrl' => url('/api/generos'),
            'displayFields' => [
                0 => ['name' => 'genero', 'caption' => 'Gênero', 'inputType' => 'text'],
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
            'title' => 'Editando gênero',
            'description' => '',
            'id' => $id,
            'url' => url('/generos'),
            'apiUrl' => url('/api/generos'),
            'entity' => $entity,
            'displayFields' => [
                0 => ['name' => 'genero', 'caption' => 'Gênero', 'inputType' => 'text'],
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
            'genero' => ['max:20'],
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
