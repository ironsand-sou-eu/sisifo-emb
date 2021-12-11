<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EseloComarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eselo_comarcas')->insert([
            [ "nome_comarca_eselo" => "ALAGOINHAS"],
            [ "nome_comarca_eselo" => "BARREIRAS"],
            [ "nome_comarca_eselo" => "BOM JESUS DA LAPA"],
            [ "nome_comarca_eselo" => "BRUMADO"],
            [ "nome_comarca_eselo" => "CAMAÇARI"],
            [ "nome_comarca_eselo" => "CANAVIEIRAS"],
            [ "nome_comarca_eselo" => "CÍCERO DANTAS"],
            [ "nome_comarca_eselo" => "COARACI"],
            [ "nome_comarca_eselo" => "CONCEIÇÃO DO COITÉ"],
            [ "nome_comarca_eselo" => "EUCLIDES DA CUNHA"],
            [ "nome_comarca_eselo" => "EUNÁPOLIS"],
            [ "nome_comarca_eselo" => "FEIRA DE SANTANA"],
            [ "nome_comarca_eselo" => "GANDU"],
            [ "nome_comarca_eselo" => "GUANAMBI"],
            [ "nome_comarca_eselo" => "ILHÉUS"],
            [ "nome_comarca_eselo" => "IPIAÚ"],
            [ "nome_comarca_eselo" => "IPIRÁ"],
            [ "nome_comarca_eselo" => "IRECÊ"],
            [ "nome_comarca_eselo" => "ITABERABA"],
            [ "nome_comarca_eselo" => "ITABUNA"],
            [ "nome_comarca_eselo" => "ITAMARAJU"],
            [ "nome_comarca_eselo" => "ITAPETINGA"],
            [ "nome_comarca_eselo" => "JACOBINA"],
            [ "nome_comarca_eselo" => "JEQUIÉ"],
            [ "nome_comarca_eselo" => "JUAZEIRO"],
            [ "nome_comarca_eselo" => "LAURO DE FREITAS"],
            [ "nome_comarca_eselo" => "LUÍS EDUARDO MAGALHÃES"],
            [ "nome_comarca_eselo" => "PAULO AFONSO"],
            [ "nome_comarca_eselo" => "PORTO SEGURO"],
            [ "nome_comarca_eselo" => "RIACHÃO DO JACUÍPE"],
            [ "nome_comarca_eselo" => "SALVADOR"],
            [ "nome_comarca_eselo" => "SANTA MARIA DA VITÓRIA"],
            [ "nome_comarca_eselo" => "SANTO ANTÔNIO DE JESUS"],
            [ "nome_comarca_eselo" => "SANTO ESTEVÃO"],
            [ "nome_comarca_eselo" => "SENHOR DO BONFIM"],
            [ "nome_comarca_eselo" => "SERRINHA"],
            [ "nome_comarca_eselo" => "SIMÕES FILHO"],
            [ "nome_comarca_eselo" => "TEIXEIRA DE FREITAS"],
            [ "nome_comarca_eselo" => "VALENÇA"],
            [ "nome_comarca_eselo" => "VITÓRIA DA CONQUISTA"]
        ]);
    }
}










































