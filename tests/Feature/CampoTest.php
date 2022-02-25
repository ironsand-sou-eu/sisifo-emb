<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class CampoTest extends TestCase
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
        $url = '/api/campos';
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
            'nomeExibicao',
            'tabela',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/campos';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/campos';
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
            'nomeExibicao',
            'tabela',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/campos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/campos/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'nome_campo' => 'campo_roçaroça' . Str::random(5),
            'nome_exibicao' => 'Campo do Roçaroça' . Str::random(5),
            'tabela_id' => 5
        ];
        $url = '/api/campos';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'nome_campo' => 'campo_roçaroça' . Str::random(5),
            'nome_exibicao' => 'Campo do Roçaroça' . Str::random(5),
            'tabela_id' => 5
        ];
        $mustHaveFields = [
            'nome_campo',
            'nome_exibicao',
            'tabela_id',
        ];
        $url = '/api/campos';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = [
            'nome_exibicao' => 'Novoroçaroça' . Str::random(5)
        ];
        $url = "/api/campos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/campos/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = [
            'nome_exibicao' => 'Novoroçaroça' . Str::random(5)
        ];
        $mustHaveFields = [
            'nome_exibicao'
        ];
        $url = "/api/campos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/campos/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/campos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/campos/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nome_campo',
            'nome_exibicao',
            'tabela_id',
            'created_at',
            'updated_at'
        ];
        $url = "/api/campos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/campos/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
