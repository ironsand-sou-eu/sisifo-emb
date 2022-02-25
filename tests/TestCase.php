<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getAllWithoutAuth($url)
    {
        $response = $this->withHeader('Authorization', '')->get($url);
        // $response->dump();
        $response->assertStatus(401);
    }

    protected function getAllWithAuth($url, $mustHaveFields, $jwt)
    {
        $response = $this->withHeader('Authorization', "Bearer $jwt")
            ->get($url);
        
        // $response->dump();
        $response->assertStatus(200)
            ->assertJson(function(AssertableJson $json) use ($mustHaveFields) {
                $json->has('fullList')
                    ->has('fullList.0', function(AssertableJson $json) use ($mustHaveFields)  {
                        $json->hasAll($mustHaveFields)->etc();
                    })->etc();
            });
    }

    protected function getOneWithoutAuth($url)
    {
        $response = $this->withHeader('Authorization', '')->get("$url/1");
        // $response->dump();
        $response->assertStatus(401);
    }
    
    protected function getOneWithAuth($url, $mustHaveFields, $jwt)
    {
        $response = $this->withHeader('Authorization', "Bearer $jwt")
        ->get("$url");
        
        // $response->dump();
        $response->assertStatus(200)
        ->assertJson(function(AssertableJson $json) use ($mustHaveFields) {
            $json->has('entity', function(AssertableJson $json) use ($mustHaveFields) {
                $json->hasAll($mustHaveFields);
            });
        });
    }
    
    protected function createWithoutAuth($url, $postData)
    {
        $response = $this->withHeader('Authorization', '')->postJson($url, $postData);
        // $response->dump();
        $response->assertStatus(401);
    }
    
    protected function createWithAuth($url, $postData, $mustHaveFields, $jwt)
    {
        $response = $this->withHeader('Authorization', "Bearer $jwt")
        ->post($url, $postData);
        
        // $response->dump();
        $response->assertStatus(201)
        ->assertJson(function(AssertableJson $json) use ($mustHaveFields) {
            $json->has('resp');
            $json->has('createdEntity', function(AssertableJson $json) use ($mustHaveFields) {
                $json->hasAll($mustHaveFields)->etc();
            })->etc();
        });
    }
    
    protected function updateWithoutAuth($url, $postData)
    {
        $response = $this->withHeader('Authorization', '')->putJson($url, $postData);
        // $response->dump();
        $response->assertStatus(401);
    }

    protected function updateWithAuth($url, $postData, $mustHaveFields, $jwt)
    {
        $response = $this->withHeader('Authorization', "Bearer $jwt")
            ->putJson($url, $postData);
        
        // $response->dump();
        $response->assertStatus(200)
            ->assertJson(function(AssertableJson $json) use ($mustHaveFields) {
                $json->has('resp');
                $json->has('updatedEntity', function(AssertableJson $json) use ($mustHaveFields) {
                        $json->hasAll($mustHaveFields);
                    });
            });
    }

    protected function deleteWithoutAuth($url)
    {
        $response = $this->withHeader('Authorization', '')->deleteJson($url);
        // $response->dump();
        $response->assertStatus(401);
    }

    protected function deleteWithAuth($url, $mustHaveFields, $jwt)
    {
        $response = $this->withHeader('Authorization', "Bearer $jwt")
            ->deleteJson($url);
        // $response->dump();

        $response->assertStatus(200)
            ->assertJson(function(AssertableJson $json) use ($mustHaveFields) {
                $json->has('resp');
                $json->has('deletedEntity', function(AssertableJson $json) use ($mustHaveFields) {
                        $json->hasAll($mustHaveFields);
                    });
            });
    }

    protected function getLastPrimaryKey($url, $jwt, $primaryKey='id')
    {
        $response = $this->withHeader('Authorization', "Bearer $jwt")
            ->get($url);
        
        $elements = $response->getData()->fullList;
        end($elements);
        $lastKey = key($elements);
        return $elements[$lastKey]->$primaryKey;
    }





}
