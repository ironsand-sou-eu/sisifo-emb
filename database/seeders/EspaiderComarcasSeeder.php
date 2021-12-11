<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspaiderComarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('espaider_comarcas')->insert([
            [ "nome_comarca_espaider" => "Alagoinhas", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Amélia Rodrigues", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Barreiras", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Bom Jesus da Lapa", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Brumado", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Camaçari", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Capim Grosso", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Canavieiras", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Cícero Dantas", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Coaraci", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Conceição do Coité", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Conceição do Jacuípe", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Entre Rios", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Euclides da Cunha", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Eunápolis", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Feira de Santana", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Gandu", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Guanambi", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Iaçu", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Ibotirama", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Ilhéus", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Ipiaú", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Ipirá", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Irecê", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Itaberaba", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Itabuna", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Itamaraju", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Itapetinga", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Itapicuru", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Jacobina", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Jequié", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Juazeiro", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Lauro de Freitas", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Livramento de Nossa Senhora", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Luís Eduardo Magalhães", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Mata de São João", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Paripiranga", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Paulo Afonso", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Porto Seguro", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Queimadas", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Riachão do Jacuípe", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Ribeira do Pombal", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Salvador", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Santa Bárbara", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Santa Maria da Vitória", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Santo Antônio de Jesus", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Santo Estêvão", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Saúde", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Senhor do Bonfim", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Serrinha", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Simões Filho", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Teixeira de Freitas", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Uauá", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Valença", "espaider_uf_id" => "BA" ],
            [ "nome_comarca_espaider" => "Vitória da Conquista", "espaider_uf_id" => "BA" ],
        ]);
    }
}
