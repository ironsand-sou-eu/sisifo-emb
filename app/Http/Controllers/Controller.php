<?php

namespace App\Http\Controllers;

use App\Models\Access\Campo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validateAndStore(Request $request, $modelClassName, $validationRules) {
        $validation = Validator::make($request->all(), $validationRules);
        if ($validation->fails() ){
            return response()->json(["resp" => "Falha ao criar o registro", $validation->errors()], 422);
        }
    
        $validatedData = $validation->validated();
        try {
            $modelClassName::create($validatedData);
        } catch (\Throwable $th) {
            return response()->json(["resp" => "Falha no banco de dados", "data" => $th], 500);
        }
        return response()->json(["resp" => "Registro criado com sucesso", "data" => $validatedData], 201);
    }

    public function validateAndUpdate(Request $request, $modelClassName, $id, $validationRules) {
        $entity = $modelClassName::findOrFail($id);
        
        $validation = Validator::make($request->all(), $validationRules);
        if ($validation->fails() ){
            return response()->json(["resp" => "Falha ao atualizar o registro", $validation->errors()], 422);
        }
    
        $validatedData = $validation->validated();
        try {
            $entity->update($validatedData);
        } catch (\Throwable $th) {
            return response()->json(["resp" => "Falha no banco de dados", "data" => $th], 500);
        }
        return response()->json(["resp" => "Registro atualizado com sucesso", "data" => $validatedData], 201);
    }

}
