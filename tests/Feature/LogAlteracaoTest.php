<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class LogAlteracaoTest extends TestCase
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
        $url = '/api/log-alteracoes';
        $this->getAllWithoutAuth($url);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiGetAllWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'campo',
            'valorAnterior',
            'valorAtual',
            'dataAlteracao',
            'alteradoPor',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/log-alteracoes';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/log-alteracoes';
        $this->getOneWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiGetOneWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'campo',
            'valorAnterior',
            'valorAtual',
            'dataAlteracao',
            'alteradoPor',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/log-alteracoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/log-alteracoes/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'campo_id' => Random::generate(1, '0-9'),
            'valor_anterior' => Random::generate(15),
            'valor_atual' => Random::generate(13),
            'data_alteracao' => 2022-02-28,
            'alterado_por' => Random::generate(1, '1-2')
        ];
        $url = '/api/log-alteracoes';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'campo_id' => Random::generate(1, '0-9'),
            'valor_anterior' => Random::generate(15),
            'valor_atual' => Random::generate(13),
            'data_alteracao' => '2022-02-28',
            'alterado_por' => Random::generate(1, '1-2')
        ];
        $mustHaveFields = [
            'campo_id',
            'valor_anterior',
            'valor_atual',
            'data_alteracao',
            'alterado_por',
        ];
        $url = '/api/log-alteracoes';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = ['valor_atual' => Random::generate(16)];
        $url = "/api/log-alteracoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/log-alteracoes/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = ['valor_atual' => Random::generate(16)];
        $mustHaveFields = ['valor_atual'];
        $url = "/api/log-alteracoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/log-alteracoes/$lastId";
        $response = $this->withHeader('Authorization', "Bearer $jwt")
            ->putJson($url, $postData);
        
        // $response->dump();
        $response->assertStatus(404);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/log-alteracoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/log-alteracoes/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'campo_id',
            'valor_anterior',
            'valor_atual',
            'data_alteracao',
            'alterado_por',
            'created_at',
            'updated_at'
        ];
        $url = "/api/log-alteracoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/log-alteracoes/$lastId";
        $response = $this->withHeader('Authorization', "Bearer $jwt")
            ->deleteJson($url);
        // $response->dump();

        $response->assertStatus(404);
    }
}
