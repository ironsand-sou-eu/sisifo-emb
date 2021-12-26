<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validateAndStore(Request $request, $modelClassName, $validationRules) {
        $validationResponse = [];
        if (!$this->successfullyValidated($request, $validationRules, $validationResponse)) {
            return $validationResponse;
        }

        try {
            $modelClassName::create($validationResponse);
        } catch (\Throwable $th) {
            return $this->dbErrorResponse($th);
        }
        return response()->json(["resp" => "Registro criado com sucesso", "data" => $validationResponse], 201);
    }

    protected function validateAndUpdate(Request $request, $modelClassName, $id, $validationRules) {
        $validationResponse = [];
        if (!$this->successfullyValidated($request, $validationRules, $validationResponse)) {
            return $validationResponse;
        }
        
        try {
            $entity = $modelClassName::findOrFail($id);
            $entity->update($validationResponse);
        } catch (\Throwable $th) {
            return $this->dbErrorResponse($th);
        }
        return response()->json(["resp" => "Registro atualizado com sucesso", "data" => $validationResponse], 200);
    }

    private function successfullyValidated(Request $request, $rules, &$validationResponse) {
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $validationResponse = response()->json(["resp" => "Erro de validação", $validation->errors()], 422);
            return false;
        }
        $validationResponse = $validation->validated();
        return true;
    }

    protected function delete($modelClassName, $id) {
        $entity = $modelClassName::find($id);
        try {
            $entity->delete();
        } catch (\Throwable $th) {
            return $this->dbErrorResponse($th);
        }
        return response()->json(["resp" => "Registro excluído com sucesso", "deletedEntity" => $entity], 200);
    }

    protected function dbErrorResponse($th) {
        return response()->json(["resp" => "Falha no banco de dados", "data" => $th], 500);
    }
}