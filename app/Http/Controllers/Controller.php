<?php

namespace App\Http\Controllers;

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

    public function validateAndStore(Request $request, string $modelClassName) {
        $validation = Validator::make($request->all(), $modelClassName::$validationRules);
        if ($validation->fails() ){
            return response()->json(["resp" => "Falha ao criar o registro", $validation->errors()], 422);
        }
    
        $validatedData = $validation->validated();
        $modelClassName::create($validatedData);
        return response()->json(["resp" => "Registro criado com sucesso", "data" => $validatedData], 201);
    }

}
