<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class GeneroTest extends TestCase
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
        $url = '/api/generos';
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
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/generos';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/generos';
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
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/generos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/generos/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'genero' => 'Roçaroça' . Str::random(5),
        ];
        $url = '/api/generos';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'genero' => 'Roçaroça' . Str::random(5),
        ];
        $mustHaveFields = [
            'genero'
        ];
        $url = '/api/generos';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = [
            'genero' => 'Novoroçaroça' . Str::random(5)
        ];
        $url = "/api/generos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/generos/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = [
            'genero' => 'Novoroçaroça' . Str::random(5)
        ];
        $mustHaveFields = [
            'genero'
        ];
        $url = "/api/generos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/generos/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/generos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/generos/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'genero',
            'created_at',
            'updated_at'
        ];
        $url = "/api/generos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/generos/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
