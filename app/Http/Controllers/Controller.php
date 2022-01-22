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
        return $this->jsonResponse(["resp" => __('db.create.success'), "createdEntity" => $validationResponse], 201);
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
        return $this->jsonResponse(["resp" => __('db.update.success'), "updatedEntity" => $validationResponse], 200);
    }

    private function successfullyValidated(Request $request, $rules, &$validationResponse) {
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $validationResponse = $this->jsonResponse(["resp" => __('validation.genericError'), $validation->errors()], 422);
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
        return $this->jsonResponse(["resp" => __('db.delete.success'), "deletedEntity" => $entity], 200);
    }

    protected function dbErrorResponse($th) {
        return $this->jsonResponse(["resp" => __('db.error'), "data" => $th], 500);
    }

    protected function isApiRoute(Request $request) {
        return $request->route()->getPrefix() === 'api';
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($this->isApiRoute($request)) {
            $entity = $this->mainModel::findOrFail($id);
            return $this->jsonResponse(["entity" => $entity]);
        } else {
            return $this->edit($request, $id);
        }
    }

    protected function jsonResponse($data, $code = 200)
    {
        return response()->json(
            $data,
            $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

}