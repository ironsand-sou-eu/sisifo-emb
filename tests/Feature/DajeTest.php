<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class DajeTest extends TestCase
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
        $url = '/api/dajes';
        $this->getAllWithoutAuth($url);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiGetAllWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'numero',
            'processo',
            'parteAdversa',
            'valor',
            'emissao',
            'vencimento',
            "tipo",
            "qtdAtos",
            "eventosAtos",
            "gerencia",
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/dajes';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/dajes';
        $this->getOneWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiGetOneWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'numero',
            'processo',
            'parteAdversa',
            'valor',
            'emissao',
            'vencimento',
            "tipo",
            "qtdAtos",
            "eventosAtos",
            "gerencia",
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/dajes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/dajes/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'numero' => '999028' . Str::random(6),
            'processo' => '1234567-28.2028.8.05.0001',
            'parte_adversa' => 'Juremildes Notinsólita de Abrantes',
            'valor' => 325.46,
            'emissao' => '2022-02-25',
            'vencimento' => '2022-03-02',
            'tipo' => 'Recurso Inominado',
            'qtd_atos' => '1',
            'eventos_atos' => '',
            'gerencia' => 'PPJCM',
        ];
        $url = '/api/dajes';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'numero' => '999028' . Str::random(6),
            'processo' => '1234567-28.2028.8.05.0001',
            'parte_adversa' => 'Juremildes Notinsólita de Abrantes',
            'valor' => 325.46,
            'emissao' => '2022-02-25',
            'vencimento' => '2022-03-02',
            'tipo' => 'Recurso Inominado',
            'qtd_atos' => '1',
            'eventos_atos' => '',
            'gerencia' => 'PPJCM',
        ];
        $mustHaveFields = [
            'numero',
            'processo',
            'parte_adversa',
            'valor',
            'emissao',
            'vencimento',
            "tipo",
            "qtd_atos",
            "eventos_atos",
            "gerencia",
        ];
        $url = '/api/dajes';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = [
            'parte_adversa' => 'Roçonildo ' . Str::random(5)
        ];
        $url = "/api/dajes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/dajes/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = ['parte_adversa' => 'Roçonildo ' . Str::random(5)];
        $mustHaveFields = ['parte_adversa'];
        $url = "/api/dajes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/dajes/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/dajes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/dajes/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'numero',
            'processo',
            'parte_adversa',
            'valor',
            'emissao',
            'vencimento',
            "tipo",
            "qtd_atos",
            "eventos_atos",
            "gerencia",
            'created_at',
            'updated_at'
        ];
        $url = "/api/dajes";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/dajes/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
