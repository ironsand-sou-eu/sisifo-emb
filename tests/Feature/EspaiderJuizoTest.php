<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;

class EspaiderJuizoTest extends TestCase
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
        $url = '/api/espaider-juizos';
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
            'slug',
            'redacaoCabecalhoJuizo',
            'redacaoResumidaJuizo',
            'espaiderComarca',
            'espaiderOrgao',
            'createdAt',
            'updatedAt'
        ];
        $url = '/api/espaider-juizos';
        $this->getAllWithAuth($url, $mustHaveFields, $jwt);
    }
    
    public function test_apiGetOneWithoutAuth()
    {
        $url = '/api/espaider-juizos';
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
            'slug',
            'redacaoCabecalhoJuizo',
            'redacaoResumidaJuizo',
            'espaiderComarca',
            'espaiderOrgao',
            'createdAt',
            'updatedAt'
        ];
        $url = "/api/espaider-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-juizos/$lastId";
        $this->getOneWithAuth($url, $mustHaveFields, $jwt);
    }

    public function test_apiCreateWithoutAuth()
    {
        $postData = [
            'nome' => 'Vara Cível de Roçaroça ' . Str::random(5),
            'slug' => 'vara-civel-de-rocaroca',
            'redacao_cabecalho_juizo' => 'da Vara Cível da comarca de Roça Roça',
            'redacao_resumida_juizo' => 'Vara Cível Roçaroça/BA',
            'espaider_comarca_id' => '3',
            'espaider_orgao_id' => '2'
        ];
        $url = '/api/espaider-juizos';
        $this->createWithoutAuth($url, $postData);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiCreateWithAuth($jwt)
    {
        $postData = [
            'nome_juizo_espaider' => 'Vara Cível de Roçaroça ' . Str::random(5),
            'slug' => 'vara-civel-de-rocaroca',
            'redacao_cabecalho_juizo' => 'da Vara Cível da comarca de Roça Roça',
            'redacao_resumida_juizo' => 'Vara Cível Roçaroça/BA',
            'espaider_comarca_id' => '3',
            'espaider_orgao_id' => '2'
        ];
        $mustHaveFields = [
            'nome_juizo_espaider',
            'slug',
            'redacao_cabecalho_juizo',
            'redacao_resumida_juizo',
            'espaider_comarca_id',
            'espaider_orgao_id'
        ];
        $url = '/api/espaider-juizos';
        $this->createWithAuth($url, $postData, $mustHaveFields, $jwt);
    }
    
    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithoutAuth($jwt)
    {
        $postData = ['nome_comarca_espaider' => 'Vara cível de Arraiá do roçaroça' . Str::random(5)];
        $url = "/api/espaider-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-juizos/$lastId";
        $this->updateWithoutAuth($url, $postData);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiUpdateWithAuth($jwt)
    {
        $postData = ['nome_juizo_espaider' => 'Vara cível de Arraiá do roçaroça' . Str::random(5)];
        $mustHaveFields = ['nome_juizo_espaider'];
        $url = "/api/espaider-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-juizos/$lastId";
        $this->updateWithAuth($url, $postData, $mustHaveFields, $jwt);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithoutAuth($jwt)
    {
        $url = "/api/espaider-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-juizos/$lastId";
        $this->deleteWithoutAuth($url);
    }

    /**
     * @depends test_apiLogin
    */
    public function test_apiDeleteWithAuth($jwt)
    {
        $mustHaveFields = [
            'id',
            'nome_juizo_espaider',
            'slug',
            'redacao_cabecalho_juizo',
            'redacao_resumida_juizo',
            'espaider_comarca_id',
            'espaider_orgao_id',
            'created_at',
            'updated_at',
        ];
        $url = "/api/espaider-juizos";
        $lastId = $this->getLastPrimaryKey($url, $jwt);
        $url = "/api/espaider-juizos/$lastId";
        $this->deleteWithAuth($url, $mustHaveFields, $jwt);
    }
}
