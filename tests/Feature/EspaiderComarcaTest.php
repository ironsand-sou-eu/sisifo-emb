<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class EspaiderComarcaTest extends TestCase
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
        $url = '/api/espaider-comarcas';
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
            'espaiderUf',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/espaider-comarcas';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/espaider-comarcas';
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
            'espaiderUf',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/espaider-comarcas";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-comarcas/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'nome' => 'Roçaroça ' . Str::random(5),
            'espaider_uf_id' => 'BA'
        ];
        $url = '/api/espaider-comarcas';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'nome_comarca_espaider' => 'Roçaroça ' . Str::random(5),
            'espaider_uf_id' => 'BA'
        ];
        $mustHaveFields = [
            'nome_comarca_espaider',
            'espaider_uf_id'
        ];
        $url = '/api/espaider-comarcas';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = ['nome_comarca_espaider' => 'Arraiá do roçaroça' . Str::random(5)];
        $url = "/api/espaider-comarcas";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-comarcas/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = ['nome_comarca_espaider' => 'Arraiá do roçaroça' . Str::random(5)];
        $mustHaveFields = ['nome_comarca_espaider'];
        $url = "/api/espaider-comarcas";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-comarcas/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/espaider-comarcas";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-comarcas/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nome_comarca_espaider',
            'espaider_uf_id',
            'created_at',
            'updated_at',
        ];
        $url = "/api/espaider-comarcas";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-comarcas/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
