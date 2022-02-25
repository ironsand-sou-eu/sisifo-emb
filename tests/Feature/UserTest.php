<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
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
        $url = '/api/users';
        $this->getAllWithoutAuth($url);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiGetAllWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nomeCompleto',
            'nomeEscolhido',
            'email',
            'emailVerifiedAt',
            'ativo',
            'avatarPathname',
            'generoDeclarado',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/users';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/users';
        $this->getOneWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiGetOneWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nomeCompleto',
            'nomeEscolhido',
            'email',
            'emailVerifiedAt',
            'ativo',
            'avatarPathname',
            'generoDeclarado',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/users";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/users/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'nome_completo' => 'Roçarocildo Jurêmio de ' . Str::random(5),
            'nome_escolhido' => 'Ross',
            'email' => Str::random(5) . '@embasa.ba.gov.br',
            'ativo' => 1,
            'avatar_path' => '',
            'genero_declarado_id' => 2,
        ];
        $url = '/api/users';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'nome_completo' => 'Roçarocildo Jurêmio de ' . Str::random(5),
            'nome_escolhido' => 'Ross',
            'email' => Str::random(5) . '@embasa.ba.gov.br',
            'password' => Str::random(15),
            'ativo' => 1,
            'avatar_path' => '',
            'genero_declarado_id' => 2,
        ];
        $mustHaveFields = [
            'nome_completo',
            'nome_escolhido',
            'genero_declarado_id',
            'email',
            'ativo',
            'avatar_path',
        ];
        $url = '/api/users';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = [
            'nome_escolhido' => 'João da Roçaroça' . Str::random(5)
        ];
        $url = "/api/users";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/users/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = [
            'nome_escolhido' => 'João da Roçaroça' . Str::random(5)
        ];
        $mustHaveFields = ['nome_escolhido'];
        $url = "/api/users";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/users/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/users";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/users/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nome_completo',
            'nome_escolhido',
            'genero_declarado_id',
            'email',
            'email_verified_at',
            'ativo',
            'avatar_path',
            'created_at',
            'updated_at',
        ];
        $url = "/api/users";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/users/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
