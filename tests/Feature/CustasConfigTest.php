<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class CustasConfigTest extends TestCase
{
    public function test_apiLogin()
    {
        $url = '/api/login';
        $postData = ['email' => 'cesar.rodriguez@embasa.ba.gov.br', 'password' => 'embasa'];
        $response = $this->postJson($url, $postData);
        $jwt = $response->getData()->access_token;
        $response->assertStatus(200)
            ->assertJson(function(AssertableJson $json) {
                $json->has('access_token');
                $json->has('user', function(AssertableJson $json) {
                        $json->hasAll(['id', 'nome_escolhido', 'email'])->etc();
                    })->etc();
            });
        return $jwt;
    }
    
    public function test_apiGetAllWithoutAuth()
    {
        $url = '/api/custas-configs';
        $this->getAllWithoutAuth($url);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiGetAllWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nome',
            'valor',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/custas-configs';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/custas-configs';
        $this->getOneWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiGetOneWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nome',
            'valor',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/custas-configs";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/custas-configs/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'nome' => 'Config do roçaroça' . Str::random(5),
            'valor' => 'Roçaroça' . Str::random(5)
        ];
        $url = '/api/custas-configs';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'nome' => 'Config do roçaroça' . Str::random(5),
            'valor' => 'Roçaroça' . Str::random(5)
        ];
        $mustHaveFields = [
            'nome',
            'valor'
        ];
        $url = '/api/custas-configs';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = ['nome' => 'Novoroçaroça' . Str::random(5)];
        $url = "/api/custas-configs";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/custas-configs/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = ['nome' => 'Novoroçaroça' . Str::random(5)];
        $mustHaveFields = ['nome'];
        $url = "/api/custas-configs";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/custas-configs/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/custas-configs";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/custas-configs/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = ['id', 'nome', 'valor', 'created_at', 'updated_at'];
        $url = "/api/custas-configs";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/custas-configs/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
