<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TabelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tabelas')->insert([
            ["nome_tabela" => "campos"],
            ["nome_tabela" => "eselo_comarcas"],
            ["nome_tabela" => "eselo_juizos"],
            ["nome_tabela" => "espaider_comarcas"],
            ["nome_tabela" => "espaider_juizos"],
            ["nome_tabela" => "espaider_orgaos"],
            ["nome_tabela" => "espaider_ufs"],
            ["nome_tabela" => "generos"],
            ["nome_tabela" => "permissoes"],
            ["nome_tabela" => "sistemas_jud_juizos"],
            ["nome_tabela" => "tabelas"],
            ["nome_tabela" => "tipos_permissoes"],
            ["nome_tabela" => "users"]
        ]);
    }
}
