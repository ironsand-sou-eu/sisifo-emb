<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return response()->json(["resp" => __('db.create.success'), "createdEntity" => $validationResponse], 201);
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
        return response()->json(["resp" => __('db.update.success'), "updatedEntity" => $validationResponse], 200);
    }

    private function successfullyValidated(Request $request, $rules, &$validationResponse) {
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $validationResponse = response()->json(["resp" => __('validation.genericError'), $validation->errors()], 422);
            return false;
        } else {
            $validationResponse = $validation->validated();
            return true;
        }
    }

    protected function delete($modelClassName, $id) {
        $entity = $modelClassName::find($id);
        try {
            $entity->delete();
        } catch (\Throwable $th) {
            return $this->dbErrorResponse($th);
        }
        return response()->json(["resp" => __('db.delete.success'), "deletedEntity" => $entity], 200);
    }

    protected function dbErrorResponse($th) {
        return response()->json(["resp" => __('db.error'), "data" => $th], 500);
    }
}