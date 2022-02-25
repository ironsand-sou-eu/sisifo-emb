<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class EseloJuizoTest extends TestCase
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
        $url = '/api/eselo-juizos';
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
            'eseloComarca',
            'espaiderJuizo',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/eselo-juizos';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/eselo-juizos';
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
            'eseloComarca',
            'espaiderJuizo',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/eselo-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/eselo-juizos/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = ['nome_juizo_eselo' => 'Vara cível de Arraiá do roçaroça' . Str::random(5)];
        $url = '/api/eselo-juizos';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'nome_juizo_eselo' => 'Vara cível de Arraiá do roçaroça' . Str::random(5),
            'eselo_comarca_id' => 2,
            'espaider_juizo_id' => 15
        ];
        $mustHaveFields = ['nome_juizo_eselo', 'eselo_comarca_id', 'espaider_juizo_id'];
        $url = '/api/eselo-juizos';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = ['nome_comarca_eselo' => 'Vara cível de Arraiá do roçaroça' . Str::random(5)];
        $url = "/api/eselo-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/eselo-juizos/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = ['nome_juizo_eselo' => 'Vara cível de Arraiá do roçaroça' . Str::random(5)];
        $mustHaveFields = ['nome_juizo_eselo'];
        $url = "/api/eselo-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/eselo-juizos/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/eselo-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/eselo-juizos/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = ['id', 'nome_juizo_eselo', 'eselo_comarca_id', 'espaider_juizo_id', 'created_at', 'updated_at'];
        $url = "/api/eselo-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/eselo-juizos/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
