<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposPermissoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_permissoes')->insert([
            ["nome_permissao" => "criação"],
            ["nome_permissao" => "leitura"],
            ["nome_permissao" => "edição"],
            ["nome_permissao" => "exclusão"],
            ["nome_permissao" => "catchanga"]
        ]);
    }
}
