<?php

namespace App\Http\Controllers;

use App\Http\Middleware\FrontendAuth;
use App\Models\Access\Campo;
use App\Models\Access\LogAlteracao;
use App\Models\Access\Tabela;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validateAndStore(Request $request, $modelClassName, $validationRules)
    {
        $validationResponse = [];
        if (! $this->successfullyValidated($request, $validationRules, $validationResponse)) {
            return $validationResponse;
        }

        try {
            $modelClassName::create($validationResponse);
        } catch (\Throwable $th) {
            return $this->dbErrorResponse($th);
        }

        return $this->jsonResponse(['resp' => __('db.create.success'), 'createdEntity' => $validationResponse], 201);
    }

    protected function validateAndUpdate(Request $request, $modelClassName, $id, $validationRules)
    {
        $validationResponse = [];
        if (! $this->successfullyValidated($request, $validationRules, $validationResponse)) {
            return $validationResponse;
        }

        try {
            $entity = $modelClassName::findOrFail($id);
            $updatedData = $this->getUpdatedFields($entity, $validationResponse);
            $entity->update($validationResponse);
        } catch (\Throwable $th) {
            return $this->dbErrorResponse($th);
        }
        $jwt = $this->getJwtFromAuthorizationHeader($request);
        $userId = FrontendAuth::getDecodedPayload($jwt)['sub'];
        $this->logUpdates($userId, $updatedData, $modelClassName);

        return $this->jsonResponse(['resp' => __('db.update.success'), 'updatedEntity' => $validationResponse], 200);
    }

    private function successfullyValidated(Request $request, $rules, &$validationResponse)
    {
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $validationResponse = $this->jsonResponse(['resp' => __('validation.genericError'), $validation->errors()], 422);

            return false;
        } else {
            $validationResponse = $validation->validated();

            return true;
        }
    }

    protected function delete($modelClassName, $id)
    {
        $entity = $modelClassName::find($id);
        try {
            $entity->delete();
        } catch (\Throwable $th) {
            return $this->dbErrorResponse($th);
        }

        return $this->jsonResponse(['resp' => __('db.delete.success'), 'deletedEntity' => $entity], 200);
    }

    protected function dbErrorResponse($th)
    {
        return $this->jsonResponse(['resp' => __('db.error'), 'data' => $th], 500);
    }

    protected function isApiRoute(Request $request)
    {
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

            return $this->jsonResponse(['entity' => $entity]);
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

    /**
     * Returns the fields whose values were changed.
     *
     * @param  Entity $entity
     * @param  array  $ValidatedInputFields
     *
     * @return array
     */
    protected function getUpdatedFields($entity, $ValidatedInputFields)
    {
        $updatedFields = [];
        foreach ($ValidatedInputFields as $fieldName => $value) {
            if ($entity->$fieldName !== $value) {
                $updatedFields[$fieldName] = [
                    'valor_anterior' => $entity->$fieldName,
                    'valor_atual' => $value,
                ];
            }
        }

        return $updatedFields;
    }

    /**
     * Log the changes.
     *
     * @param  int $userId
     * @param  array  $updatedFields
     *
     * @return array
     */
    protected function logUpdates($userId, $updatedFields, $modelName)
    {
        if ($modelName == \App\Models\Access\LogAlteracao::class) {
            return;
        }

        $table = $this->getTableFromModelName($modelName);

        foreach ($updatedFields as $campoName => $valuesArray) {
            $campo = Campo::where('nome_campo', $campoName)->where('tabela_id', $table->id)->first();
            $this->logIndividualUpdate($campo, $userId, $valuesArray);
        }
    }

    protected function logIndividualUpdate($campo, $userId, $valuesArray)
    {
        $valuesArray['campo_id'] = $campo->id;
        $valuesArray['data_alteracao'] = date('Y-m-d H:i:s');
        $valuesArray['alterado_por'] = $userId;
        LogAlteracao::create($valuesArray);
    }

    protected function getJwtFromAuthorizationHeader(Request $request)
    {
        $jwt = $request->header('authorization');
        $jwt = str_replace('Bearer ', '', $jwt);

        return $jwt;
    }

    protected function getTableFromModelName($modelName)
    {
        $model = new $modelName;
        $tableName = $model->getTable();

        return Tabela::where('nome_tabela', $tableName)->first();
    }
}
