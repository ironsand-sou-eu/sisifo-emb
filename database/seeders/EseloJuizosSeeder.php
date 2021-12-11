<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EseloJuizosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eseloJuizos = [
            ["10ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "10ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["11ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "11ª Vara SJE Consumidor de Salvador - Matutino"],
            ["12ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "12ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["13ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "13ª Vara SJE Consumidor de Salvador - Matutino"],
            ["14ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "14ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["15ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "15ª Vara SJE Consumidor de Salvador - Matutino"],
            ["16ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "16ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["17ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "17ª Vara SJE Consumidor de Salvador - Matutino"],
            ["18ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "18ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["19ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS CONSUMIDOR - SALVADOR", "SALVADOR", "19ª Vara SJE Consumidor de Salvador - Matutino"],
            ["20ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "20ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["1ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "1ª Vara SJE Causas Comuns de Salvador - Matutino"],
            ["1ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "1ª Vara SJE Consumidor de Salvador - Matutino"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - BARREIRAS - BARREIRAS - BARREIRAS - BARREIRAS - BARREIRAS", "BARREIRAS", "1ª Vara SJE de Barreiras"],
            ["1ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS - CAMAÇARI", "CAMAÇARI", "1ª Vara SJE de Camaçari"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - EUNÁPOLIS", "EUNÁPOLIS", "1ª Vara SJE de Eunápolis"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - GUANAMBI", "GUANAMBI", "1ª Vara SJE de Guanambi"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ILHÉUS - ILHÉUS - ILHÉUS - ILHÉUS - ILHÉUS", "ILHÉUS", "1ª Vara SJE de Ilhéus"],
            ["JUIZADO ESPECIAL CIVEL CRIMINAL - IRECÊ", "IRECÊ", "1ª Vara SJE de Irecê"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ITABUNA", "ITABUNA", "1ª Vara SJE de Itabuna - Vespertino"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ITAPETINGA", "ITAPETINGA", "1ª Vara SJE de Itapetinga"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - JACOBINA", "JACOBINA", "1ª Vara SJE de Jacobina"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - JEQUIÉ", "JEQUIÉ", "1ª Vara SJE de Jequié"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC   - JUAZEIRO", "JUAZEIRO", "1ª Vara SJE de Juazeiro"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - LAURO DE FREITAS - LAURO DE FREITAS - LAURO DE FREITAS - LAURO DE FREITAS - LAURO DE FREITAS", "LAURO DE FREITAS", "1ª Vara SJE de Lauro de Freitas"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - PAULO AFONSO", "PAULO AFONSO", "1ª Vara SJE de Paulo Afonso"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - PORTO SEGURO", "PORTO SEGURO", "1ª Vara SJE de Porto Seguro"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - SERRINHA", "SERRINHA", "1ª Vara SJE de Serrinha"],
            ["JUIZADO ESPECIAL CÍVEL - SIMÕES FILHO", "SIMÕES FILHO", "1ª Vara SJE de Simões Filho"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - TEIXEIRA DE FREITAS - TEIXEIRA DE FREITAS - TEIXEIRA DE FREITAS", "TEIXEIRA DE FREITAS", "1ª Vara SJE de Teixeira de Freitas"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - VITÓRIA DA CONQUISTA", "VITÓRIA DA CONQUISTA", "1ª Vara SJE de Vitória da Conquista"],
            ["1ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE TRÂNSITO - SALVADOR", "SALVADOR", "1ª Vara SJE Trânsito de Salvador - Matutino"],
            ["2ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "2ª Vara SJE Causas Comuns de Salvador - Vespertino"],
            ["2ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "2ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - BARREIRAS - BARREIRAS - BARREIRAS - BARREIRAS - BARREIRAS", "BARREIRAS", "2ª Vara SJE de Barreiras"],
            ["2ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS - CAMAÇARI", "CAMAÇARI", "2ª Vara SJE de Camaçari"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - EUNÁPOLIS", "EUNÁPOLIS", "2ª Vara SJE de Eunápolis"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ILHÉUS - ILHÉUS - ILHÉUS - ILHÉUS - ILHÉUS", "ILHÉUS", "2ª Vara SJE de Ilhéus"],
            ["JUIZADO ESPECIAL CIVEL CRIMINAL - IRECÊ", "IRECÊ", "2ª Vara SJE de Irecê"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ITABUNA", "ITABUNA", "2ª Vara SJE de Itabuna"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - JACOBINA", "JACOBINA", "2ª Vara SJE de Jacobina"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - JEQUIÉ", "JEQUIÉ", "2ª Vara SJE de Jequié"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC   - JUAZEIRO", "JUAZEIRO", "2ª Vara SJE de Juazeiro"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - LAURO DE FREITAS - LAURO DE FREITAS - LAURO DE FREITAS - LAURO DE FREITAS - LAURO DE FREITAS", "LAURO DE FREITAS", "2ª Vara SJE de Lauro de Freitas"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - PAULO AFONSO", "PAULO AFONSO", "2ª Vara SJE de Paulo Afonso"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - PORTO SEGURO", "PORTO SEGURO", "2ª Vara SJE de Porto Seguro"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - TEIXEIRA DE FREITAS - TEIXEIRA DE FREITAS - TEIXEIRA DE FREITAS", "TEIXEIRA DE FREITAS", "2ª Vara SJE de Teixeira de Freitas"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - SERRINHA", "SERRINHA", "2ª Vara SJE de Serrinha"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - VITÓRIA DA CONQUISTA", "VITÓRIA DA CONQUISTA", "2ª Vara SJE de Vitória da Conquista"],
            ["2ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE TRÂNSITO - SALVADOR", "SALVADOR", "2ª Vara SJE Trânsito de Salvador - Vespertino"],
            ["3ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "3ª Vara SJE Causas Comuns de Salvador - Matutino"],
            ["3ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "3ª Vara SJE Consumidor de Salvador - Matutino"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ILHÉUS - ILHÉUS - ILHÉUS - ILHÉUS - ILHÉUS", "ILHÉUS", "3ª Vara SJE de Ilhéus"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ITABUNA", "ITABUNA", "3ª Vara SJE de Itabuna"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - VITÓRIA DA CONQUISTA", "VITÓRIA DA CONQUISTA", "3ª Vara SJE de Vitória da Conquista"],
            ["3ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE TRÂNSITO - SALVADOR", "SALVADOR", "3ª Vara SJE Trânsito de Salvador - Vespertino"],
            ["4ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "4ª Vara SJE Causas Comuns de Salvador - Vespertino"],
            ["4ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "4ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["5ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "5ª Vara SJE Causas Comuns de Salvador - Matutino"],
            ["5ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "5ª Vara SJE Consumidor de Salvador - Matutino"],
            ["6ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "6ª Vara SJE Causas Comuns de Salvador - Vespertino"],
            ["6ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "6ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["7ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "7ª Vara SJE Causas Comuns de Salvador - Matutino"],
            ["7ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "7ª Vara SJE Consumidor de Salvador - Matutino"],
            ["8ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DE CAUSAS COMUNS - SALVADOR", "SALVADOR", "8ª Vara SJE Causas Comuns de Salvador - Vespertino"],
            ["8ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "8ª Vara SJE Consumidor de Salvador - Vespertino"],
            ["9ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS DO CONSUMIDOR - SALVADOR", "SALVADOR", "9ª Vara SJE Consumidor de Salvador - Matutino"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - CÍCERO DANTAS", "CÍCERO DANTAS", "Vara SJE Cível de Cícero Dantas"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ITAMARAJU", "ITAMARAJU", "Vara SJE Cível de Itamaraju"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - SANTA MARIA DA VITÓRIA", "SANTA MARIA DA VITÓRIA", "Vara SJE Cível de Santa Maria da Vitória"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - BOM JESUS DA LAPA", "BOM JESUS DA LAPA", "Vara SJE de Bom Jesus da Lapa"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - BRUMADO", "BRUMADO", "Vara SJE Cível e Criminal de Brumado"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - COARACI", "COARACI", "Vara SJE Cível e Criminal de Coaraci"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - IPIAÚ", "IPIAÚ", "Vara SJE Cível e Criminal de Ipiaú"],
            ["JUIZADO ESPECIAL CÍVEL / CRIMINAL - JCC/JC/JDC   - IPIRÁ", "IPIRÁ", "Vara SJE Cível e Criminal de Ipirá"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - RIACHÃO DO JACUÍPE", "RIACHÃO DO JACUÍPE", "Vara SJE Cível e Criminal de Riachão do Jacuípe"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ALAGOINHAS", "ALAGOINHAS", "Vara SJE de Alagoinhas"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - CANAVIEIRAS", "CANAVIEIRAS", "Vara SJE de Canavieiras"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - CONCEIÇÃO DO COITÉ", "CONCEIÇÃO DO COITÉ", "Vara SJE de Conceição do Coité"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - EUCLIDES DA CUNHA", "EUCLIDES DA CUNHA", "Vara SJE de Euclides da Cunha"],
            ["JUIZADO ESPECIAL CÍVEL - GANDU", "GANDU", "Vara SJE de Gandu"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - ITABERABA", "ITABERABA", "Vara SJE de Itaberaba"],
            ["VARA DO SISTEMA DOS JUIZADOS ESPECIAIS - LUIS EDUARDO MAGALHÃES", "LUIS EDUARDO MAGALHÃES", "Vara SJE de Luís Eduardo Magalhães"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - SANTO ANTONIO DE JESUS", "SANTO ANTONIO DE JESUS", "Vara SJE de Santo Antônio de Jesus"],
            ["JUIZADO ESPECIAL CÍVEL - SANTO ESTEVÃO", "SANTO ESTEVÃO", "Vara SJE de Santo Estêvão"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - SENHOR DO BONFIM", "SENHOR DO BONFIM", "Vara SJE de Senhor do Bonfim"],
            ["JUIZADO ESPECIAL CÍVEL - JCC/JDC - VALENÇA", "VALENÇA", "Vara SJE de Valença"],
            ["4ª VARA DO SISTEMA DOS JUIZADOS ESPECIAIS - FEIRA DE SANTANA - FEIRA DE SANTANA - FEIRA DE SANTANA", "FEIRA DE SANTANA", "4ª Vara SJE de Feira de Santana"]
        ];

        $paramsInsert = [];
        foreach($eseloJuizos as $juizo) {
            $arr["nome_juizo_eselo"] = $juizo[0];
            $arr["eselo_comarca_id"] = DB::table("eselo_comarcas")->where("nome_comarca_eselo", $juizo[1])->value("id");
            $arr["espaider_juizo_id"] = DB::table("espaider_juizos")->where("nome_juizo_espaider", $juizo[2])->value("id");
            $paramsInsert[] = $arr;
        }

        DB::table('eselo_juizos')->insert($paramsInsert);
    }
}
