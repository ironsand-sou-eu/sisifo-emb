<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class TipoPermissaoTest extends TestCase
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
        $url = '/api/tipos-permissoes';
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
        $url = '/api/tipos-permissoes';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/tipos-permissoes';
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
        $url = "/api/tipos-permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/tipos-permissoes/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'nome_permissao' => 'Roça' . Str::random(5),
        ];
        $url = '/api/tipos-permissoes';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'nome_permissao' => 'Roça' . Str::random(5),
        ];
        $mustHaveFields = [
            'nome_permissao'
        ];
        $url = '/api/tipos-permissoes';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = [
            'nome_permissao' => 'Novor' . Str::random(5)
        ];
        $url = "/api/tipos-permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/tipos-permissoes/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = [
            'nome_permissao' => 'Novor' . Str::random(5)
        ];
        $mustHaveFields = [
            'nome_permissao'
        ];
        $url = "/api/tipos-permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/tipos-permissoes/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/tipos-permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/tipos-permissoes/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nome_permissao',
            'created_at',
            'updated_at'
        ];
        $url = "/api/tipos-permissoes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/tipos-permissoes/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
