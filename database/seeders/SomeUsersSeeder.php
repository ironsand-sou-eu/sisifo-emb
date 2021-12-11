<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SomeUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generoId = DB::table("generos")->where("genero", "Masculino")->value("id");

        DB::table('users')->insert([
            [
                "nome_completo" => "César Braga Lins Bamberg Rodriguez",
                "nome_escolhido" => "Don César de Toledo",
                "genero_declarado_id" => $generoId,
                "email" => "cesar.rodriguez@embasa.ba.gov.br",
                "email_verified_at" => now(),
                "password" => "123",
                "ativo" => true
            ],
            
            [
                "nome_completo" => "admin",
                "nome_escolhido" => "FTI",
                "genero_declarado_id" => $generoId,
                "email" => "fti@embasa.ba.gov.br",
                "email_verified_at" => now(),
                "password" => "123",
                "ativo" => true
                ]
        ]);
    }
}
