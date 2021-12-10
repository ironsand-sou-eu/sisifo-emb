<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generos')->insert([
            ["genero" => "Feminino"],
            ["genero" => "Masculino"],
            ["genero" => "Neutro"],
            ["genero" => "Não binário"],
            ["genero" => "Outros"],
        ]);
    }
}
