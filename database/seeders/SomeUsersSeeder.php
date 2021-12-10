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
        DB::table('users')->insert([
            [
                "nome_completo" => "César Braga Lins Bamberg Rodriguez",
                "nome_escolhido" => "Don César de Toledo",
                "genero_declarado_id" => 2,
                "email" => "cesar.rodriguez@embasa.ba.gov.br",
                "email_verified_at" => now(),
                "password" => "123",
                "ativo" => true
            ],
            
            [
                "nome_completo" => "admin",
                "nome_escolhido" => "FTI",
                "genero_declarado_id" => 2,
                "email" => "fti@embasa.ba.gov.br",
                "email_verified_at" => now(),
                "password" => "123",
                "ativo" => true
                ]
        ]);
    }
}
