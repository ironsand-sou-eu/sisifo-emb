<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Nette\Utils\Random;

class EspaiderUfTest extends TestCase
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
        $url = '/api/espaider-ufs';
        $this->getAllWithoutAuth($url);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiGetAllWithAuth($jwt)
    {
        $mustHaveFields = [
            'sigla',
            'nome',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/espaider-ufs';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/espaider-ufs';
        $this->getOneWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiGetOneWithAuth($jwt)
    {
        $mustHaveFields = [
            'sigla',
            'nome',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/espaider-ufs";
        $lastId = $this->getLastPrimaryKey($url, $jwt, 'sigla');
        $url = "/api/espaider-ufs/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'sigla' => Random::generate(2, 'A-Z'),
            'nome_uf_espaider' => 'Roçolândia' . Random::generate(5),
        ];
        $url = '/api/espaider-ufs';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'sigla' => 'RC',
            'nome_uf_espaider' => 'Roçolândia' . Random::generate(5),
        ];
        $mustHaveFields = [
            'sigla',
            'nome_uf_espaider'
        ];
        $url = '/api/espaider-ufs';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = [
            'nome_uf_espaider' => 'Roçolândia' . Random::generate(5)
        ];
        $url = "/api/espaider-ufs";
        $lastId = $this->getLastPrimaryKey($url, $jwt, 'sigla');
        $url = "/api/espaider-ufs/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = [
            'nome_uf_espaider' => 'Roçolândia' . Random::generate(5),
        ];
        $mustHaveFields = ['nome_uf_espaider'];
        $url = "/api/espaider-ufs";
        $lastId = $this->getLastPrimaryKey($url, $jwt, 'sigla');
        $url = "/api/espaider-ufs/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/espaider-ufs";
        $lastId = $this->getLastPrimaryKey($url, $jwt, 'sigla');
        $url = "/api/espaider-ufs/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'nome_uf_espaider',
            'sigla',
            'created_at',
            'updated_at',
        ];
        $url = "/api/espaider-ufs";
        $lastId = $this->getLastPrimaryKey($url, $jwt, 'sigla');
        $url = "/api/espaider-ufs/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
