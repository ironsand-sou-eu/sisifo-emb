<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspaiderOrgaosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('espaider_orgaos')->insert([
            [ "sigla_orgao" => "TJAC", "nome_orgao_espaider" => "TJ/AC" ], 
            [ "sigla_orgao" => "TJAL", "nome_orgao_espaider" => "TJ/AL" ], 
            [ "sigla_orgao" => "TJAM", "nome_orgao_espaider" => "TJ/AM" ], 
            [ "sigla_orgao" => "TJAP", "nome_orgao_espaider" => "TJ/AP" ], 
            [ "sigla_orgao" => "TJBA Tribunal", "nome_orgao_espaider" => "TJ/BA - Tribunal" ], 
            [ "sigla_orgao" => "TJBA Fazenda Pública", "nome_orgao_espaider" => "TJ/BA - Varas da Fazenda Pública" ], 
            [ "sigla_orgao" => "TJBA Varas", "nome_orgao_espaider" => "TJ/BA - Varas de Consumo, Cíveis, Comerciais, Criminais e varas únicas" ], 
            [ "sigla_orgao" => "TJBA Juizados", "nome_orgao_espaider" => "TJ/BA - Varas dos Sistemas dos Juizados Especiais" ], 
            [ "sigla_orgao" => "TJCE", "nome_orgao_espaider" => "TJ/CE" ], 
            [ "sigla_orgao" => "TJDFT", "nome_orgao_espaider" => "TJ/DFT" ], 
            [ "sigla_orgao" => "TJES", "nome_orgao_espaider" => "TJ/ES" ], 
            [ "sigla_orgao" => "TJGO", "nome_orgao_espaider" => "TJ/GO" ], 
            [ "sigla_orgao" => "TJMA", "nome_orgao_espaider" => "TJ/MA" ], 
            [ "sigla_orgao" => "TJMG", "nome_orgao_espaider" => "TJ/MG" ], 
            [ "sigla_orgao" => "TJMS", "nome_orgao_espaider" => "TJ/MS" ], 
            [ "sigla_orgao" => "TJMT", "nome_orgao_espaider" => "TJ/MT" ], 
            [ "sigla_orgao" => "TJPA", "nome_orgao_espaider" => "TJ/PA" ], 
            [ "sigla_orgao" => "TJPB", "nome_orgao_espaider" => "TJ/PB" ], 
            [ "sigla_orgao" => "TJPE", "nome_orgao_espaider" => "TJ/PE" ], 
            [ "sigla_orgao" => "TJPI", "nome_orgao_espaider" => "TJ/PI" ], 
            [ "sigla_orgao" => "TJPR", "nome_orgao_espaider" => "TJ/PR" ], 
            [ "sigla_orgao" => "TJRJ", "nome_orgao_espaider" => "TJ/RJ" ], 
            [ "sigla_orgao" => "TJRN", "nome_orgao_espaider" => "TJ/RN" ], 
            [ "sigla_orgao" => "TJRO", "nome_orgao_espaider" => "TJ/RO" ], 
            [ "sigla_orgao" => "TJRR", "nome_orgao_espaider" => "TJ/RR" ], 
            [ "sigla_orgao" => "TJRS", "nome_orgao_espaider" => "TJ/RS" ], 
            [ "sigla_orgao" => "TJSC", "nome_orgao_espaider" => "TJ/SC" ], 
            [ "sigla_orgao" => "TJSE", "nome_orgao_espaider" => "TJ/SE" ], 
            [ "sigla_orgao" => "TJSP", "nome_orgao_espaider" => "TJ/SP" ], 
            [ "sigla_orgao" => "TJTO", "nome_orgao_espaider" => "TJ/TO" ]
        ]);
    }
}
