<?php

namespace App\Http\Controllers;

use App\Exceptions\DbErrorException;
use App\Exceptions\EntryNotFoundException;
use App\Exceptions\LoggingException;
use App\Exceptions\ValidationErrorException;
use App\Http\Resources\GlobalResource;
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
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalIndex(Request $request, $params)
    {
        if ($this->isApiRoute($request)) {
            $modelResourceName = $this->getResourceName();
            if (array_key_exists('nestedRelations', $params)) {
                $fullList = $modelResourceName::collection($this->mainModel::with($params['nestedRelations'])->get());
            } else {
                $fullList = $modelResourceName::collection($this->mainModel::all());
            }
            return GlobalResource::jsonResponse(['fullList' => $fullList]);

        } else {
            $jwt = $request->cookie('jat');
            $params['jwt'] = $jwt;
            return view($params['indexView'] ?? 'components.index', $params);
        }
    }

    protected function getResourceName()
    {
        $modelBaseName = $this->stripNamespaceFromClassName($this->mainModel);
        $modelResourceName = "App\\Http\\Resources\\{$modelBaseName}Resource";
        return $modelResourceName;
    }

    private function stripNamespaceFromClassName($className) {
        return substr($className, strrpos($className, '\\') + 1);
    }

    public function show(Request $request, $id)
    {
        $entity = $this->mainModel::findOrFail($id);
        if ($this->isApiRoute($request)) {
            $modelResourceName = $this->getResourceName();
            $resource = new $modelResourceName($entity);
            return GlobalResource::jsonResponse(['entity' => $resource]);
        } else {
            return $this->edit($request, $id);
        }
    }

    protected function isApiRoute(Request $request)
    {
        return $request->route()->getPrefix() === 'api';
    }

    protected function delete($modelClassName, $id)
    {
        $entity = $modelClassName::find($id);
        try {
            $entity->delete();
        } catch (\Throwable $th) {
            throw new DbErrorException($th);
        }

        return GlobalResource::jsonResponse(['resp' => __('db.delete.success'), 'deletedEntity' => $entity], 200);
    }

    protected function validateAndStore(Request $request, $modelClassName, $validationRules)
    {
        $validationResponse = $this->validateData($request, $validationRules);
        $createdData = $this->storeData($modelClassName, $validationResponse);
        $this->logUpdates($request, $createdData, $modelClassName);
        return GlobalResource::jsonResponse(['resp' => __('db.create.success'), 'createdEntity' => $validationResponse], 201);
    }

    protected function validateAndUpdate(Request $request, $modelClassName, $id, $validationRules)
    {
        $validationResponse = $this->validateData($request, $validationRules);
        $entity = $this->getEntity($modelClassName, $id);
        $updatedData = $this->updateData($entity, $validationResponse);
        $this->logUpdates($request, $updatedData, $modelClassName);
        return GlobalResource::jsonResponse(['resp' => __('db.update.success'), 'updatedEntity' => $validationResponse], 200);
    }

    private function validateData(Request $request, $rules)
    {
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails())
            throw new ValidationErrorException($validation->errors());
        
        return $validation->validated();
    }

    private function storeData($modelClassName, $validationResponse)
    {
        try {
            $pwdHashedValidationResponse = $this->hashFieldsNamedPassword($validationResponse);
            $dataToLog = $this->getFieldsToLogOnCreate($pwdHashedValidationResponse);
            $modelClassName::create($pwdHashedValidationResponse);
        } catch (\Throwable $th) {
            throw new DbErrorException($th);
        }
        return $dataToLog;
    }

    private function getEntity($modelClassName, $id)
    {
        try {
            $entity = $modelClassName::findOrFail($id);
        } catch (\Throwable $th) {
            throw new EntryNotFoundException($th);
        }
        return $entity;
    }

    private function updateData($entity, $validationResponse)
    {
        try {
            $dataToLog = $this->getFieldsToLogOnUpdate($validationResponse, $entity);
            $entity->update($validationResponse);
        } catch (\Throwable $th) {
            throw new DbErrorException($th);
        }
        return $dataToLog;
    }

    protected function getFieldsToLogOnUpdate($ValidatedInputFields, $entity)
    {
        $fieldsToUpdate = [];
        foreach ($ValidatedInputFields as $fieldName => $value) {
            if ($entity->$fieldName !== $value) {
                $fieldsToUpdate[$fieldName] = [
                    'valor_anterior' => $entity->$fieldName,
                    'valor_atual' => $value,
                ];
            }
        }

        return $fieldsToUpdate;
    }

    protected function hashFieldsNamedPassword($dataArray) {
        foreach ($dataArray as $key => &$value) {
            if($key == 'password')
                $value = Hash::make($value);
        }
        return $dataArray;
    }

    protected function getFieldsToLogOnCreate($validatedInputFields)
    {
        $fieldsToCreate = [];
        foreach ($validatedInputFields as $fieldName => $value) {
            if($fieldName == 'password')
                break;

            $fieldsToCreate[$fieldName] = [
                'valor_anterior' => '',
                'valor_atual' => $value,
            ];
        }
        return $fieldsToCreate;
    }

    protected function logUpdates($request, $updatedFields, $modelName)
    {
        if ($modelName == \App\Models\Access\LogAlteracao::class)
        return; // Não se logam alterações na tabela de log
        
        $table = $this->getTableFromModelName($modelName);
        $userId = $this->getCurrentUserId($request);
        foreach ($updatedFields as $campoName => $valuesArray) {
            $campo = Campo::where('nome_campo', $campoName)->where('tabela_id', $table->id)->first();
            $this->logIndividualUpdate($campo, $userId, $valuesArray);
        }
    }

    protected function getCurrentUserId($request)
    {
        $jwtHeader = $this->getJwtFromAuthorizationHeader($request);
        $jwtCookie = $this->getJwtFromJatCookie($request);
        $jwt = $jwtHeader ?: $jwtCookie;
        $userId = FrontendAuth::getDecodedPayload($jwt)['sub'];
        return $userId;
    }

    protected function getJwtFromJatCookie(Request $request)
    {
        return $request->cookie('jat');
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

    private function logIndividualUpdate($campo, $userId, $valuesArray)
    {
        if ($valuesArray['valor_anterior'] == $valuesArray['valor_atual'])
            return;
        $valuesArray['campo_id'] = $campo->id;
        $valuesArray['data_alteracao'] = date('Y-m-d H:i:s');
        $valuesArray['alterado_por'] = $userId;
        LogAlteracao::create($valuesArray);
    }

}
