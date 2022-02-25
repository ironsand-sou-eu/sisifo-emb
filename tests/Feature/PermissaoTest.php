<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class PermissaoTest extends TestCase
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
        $url = '/api/permissoes';
        $this->getAllWithoutAuth($url);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiGetAllWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'user',
            'tabela',
            'tipoPermissao',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/permissoes';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/permissoes';
        $this->getOneWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiGetOneWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'user',
            'tabela',
            'tipoPermissao',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/permissoes/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'user_id' => Random::generate(1, '1-2'),
            'tabela_id' => Random::generate(1, '0-9'),
            'tipo_permissao_id' => Random::generate(1, '0-9')
        ];
        $url = '/api/permissoes';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'user_id' => Random::generate(1, '1-2'),
            'tabela_id' => Random::generate(1, '0-9'),
            'tipo_permissao_id' => Random::generate(1, '1-2')
        ];
        $mustHaveFields = [
            'user_id',
            'tabela_id',
            'tipo_permissao_id'
        ];
        $url = '/api/permissoes';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = ['tabela_id' => Random::generate(1, '0-9')];
        $url = "/api/permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/permissoes/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = ['tabela_id' => Random::generate(1, '0-9')];
        $mustHaveFields = ['tabela_id'];
        $url = "/api/permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/permissoes/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/permissoes/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'user_id',
            'tabela_id',
            'tipo_permissao_id',
            'created_at',
            'updated_at'
        ];
        $url = "/api/permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/permissoes/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
