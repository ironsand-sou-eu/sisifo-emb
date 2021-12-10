<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspaiderUfsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('espaider_ufs')->insert([
            ["sigla" => "AC", "nome_uf_espaider" => "Acre"],
            ["sigla" => "AL", "nome_uf_espaider" => "Alagoas"],
            ["sigla" => "AM", "nome_uf_espaider" => "Amazonas"],
            ["sigla" => "AP", "nome_uf_espaider" => "Amapá"],
            ["sigla" => "BA", "nome_uf_espaider" => "Bahia"],
            ["sigla" => "CE", "nome_uf_espaider" => "Ceará"],
            ["sigla" => "DF", "nome_uf_espaider" => "Distrito Federal"],
            ["sigla" => "ES", "nome_uf_espaider" => "Espírito Santo"],
            ["sigla" => "GO", "nome_uf_espaider" => "Goiás"],
            ["sigla" => "MA", "nome_uf_espaider" => "Maranhão"],
            ["sigla" => "MG", "nome_uf_espaider" => "Minhas Gerais"],
            ["sigla" => "MS", "nome_uf_espaider" => "Mato Grosso do Sul"],
            ["sigla" => "MT", "nome_uf_espaider" => "Mato Grosso"],
            ["sigla" => "PA", "nome_uf_espaider" => "Pará"],
            ["sigla" => "PB", "nome_uf_espaider" => "Paraíba"],
            ["sigla" => "PE", "nome_uf_espaider" => "Pernambuco"],
            ["sigla" => "PI", "nome_uf_espaider" => "Piauí"],
            ["sigla" => "PR", "nome_uf_espaider" => "Paraná"],
            ["sigla" => "RJ", "nome_uf_espaider" => "Rio de Janeiro"],
            ["sigla" => "RN", "nome_uf_espaider" => "Rio Grande do Norte"],
            ["sigla" => "RO", "nome_uf_espaider" => "Rondônia"],
            ["sigla" => "RR", "nome_uf_espaider" => "Roraima"],
            ["sigla" => "RS", "nome_uf_espaider" => "Rio Grande do Sul"],
            ["sigla" => "SC", "nome_uf_espaider" => "Santa Catarina"],
            ["sigla" => "SE", "nome_uf_espaider" => "Sergipe"],
            ["sigla" => "SP", "nome_uf_espaider" => "São Paulo"],
            ["sigla" => "TO", "nome_uf_espaider" => "Tocantins"]
        ]);
    }
}
