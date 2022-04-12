<?php

namespace App\Exports;

use App\Models\BizRules\Daje;
use App\Models\BizRules\CustasConfig;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class DajesExport implements FromCollection, WithHeadings, WithColumnWidths
{
    protected $initialDate;
    protected $finalDate;

    public function __construct($initialDate, $finalDate)
    {
        $this->initialDate = $initialDate;
        $this->finalDate = $finalDate;
    }

    public function headings(): array {
        return [
            "Data da Fatura", "Data de Lançamento", "Tipo de Documento",
            "Período", "Referência Cabeçalho", "Texto Cabeçalho",
            "Nº Conta Cliente", "Nome", "CNPJ", "CPF", "Rua", "Local",
            "CEP", "Montante", "Condições de Pagamento", "Forma de Pagamento",
            "Atribuição Fornecedor", "Atribuição Fornecedor", "Banco Empresa",
            "Chave Breve da conta", "Conta Razao", "Montante", "Atribuição Despesa",
            "Texto Despesa", "Centro de Custo", "Código de Barras"
        ];
    }

    public function columnWidths(): array {
        return [
            'A' => 13, 'B' => 13, 'C' => 7, 'D' => 7, 'E' => 20,
            'F' => 15, 'G' => 15, 'H' => 8, 'I' => 4, 'J' => 4,
            'K' => 4, 'L' => 11, 'M' => 10, 'N' => 9, 'O' => 9,
            'P' => 9, 'Q' => 9, 'R' => 65, 'S' => 9, 'T' => 9,
            'U' => 11, 'V' => 9, 'W' => 7, 'X' => 25, 'Y' => 15,
            'Z' => 50
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $dajesByDate = Daje::where('emissao', '>=', $this->initialDate)
                ->where('emissao', '<=', $this->finalDate)
                ->select([
                    'numero', 'processo', 'valor', 'codigo_barras',
                    'tipo', 'qtd_atos', 'eventos_atos', 'gerencia'
                    ])
                ->get();
        $sapConfigs = CustasConfig::where("nome", "Atribuição Despesa")
                ->orWhere("nome", "Atribuição Fornecedor")
                ->orWhere("nome", "Banco Empresa")
                ->orWhere("nome", "Centro de Custo")
                ->orWhere("nome", "CEP")
                ->orWhere("nome", "Chave Breve da conta")
                ->orWhere("nome", "CNPJ")
                ->orWhere("nome", "Condições de Pagamento")
                ->orWhere("nome", "Conta Razao")
                ->orWhere("nome", "CPF")
                ->orWhere("nome", "Forma de Pagamento")
                ->orWhere("nome", "Local")
                ->orWhere("nome", "Nº Conta Cliente")
                ->orWhere("nome", "Nome")
                ->orWhere("nome", "Referência Cabeçalho")
                ->orWhere("nome", "Rua")
                ->orWhere("nome", "Texto Cabeçalho")
                ->orWhere("nome", "Tipo de Documento")
                ->select(["nome", "valor"])
                ->get()
                ->pluck('valor', 'nome');

        $dajesByDate->transform(function($item) use ($sapConfigs) {
            $descriptionText = "Pgto $item->gerencia - DAJE $item->numero - $item->qtd_atos $item->tipo "
                               . ($item->eventos_atos ? "($item->eventos_atos)" : "");
            $sapDate = date('d.m.Y');
            $sapDateAgain = $sapDate;
            $periodo = date('n');
            $remainingConfigs = [
                'descriptionText' => $descriptionText,
                'sapDate' => $sapDate,
                'sapDateAgain' => $sapDateAgain,
                'periodo' => $periodo,
                'valorAgain' => $item->valor
            ];

            return collect($item)
                ->merge($sapConfigs)
                ->merge($remainingConfigs)
                ->except(['numero', 'tipo', 'qtd_atos', 'eventos_atos', 'gerencia'])
                ->sortKeysUsing(function($keyA, $keyB) {
                    $correctKeysOrder = [
                        "sapDate",
                        "sapDateAgain",
                        "Tipo de Documento",
                        "periodo",
                        "Referência Cabeçalho",
                        "Texto Cabeçalho",
                        "Nº Conta Cliente",
                        "Nome",
                        "CNPJ",
                        "CPF",
                        "Rua",
                        "Local",
                        "CEP",
                        "valor",
                        "Condições de Pagamento",
                        "Forma de Pagamento",
                        "Atribuição Fornecedor",
                        "descriptionText",
                        "Banco Empresa",
                        "Chave Breve da conta",
                        "Conta Razao",
                        "valorAgain",
                        "Atribuição Despesa",
                        "processo",
                        "Centro de Custo",
                        "codigo_barras",
                    ];
                    $orderKeyA = array_search($keyA, $correctKeysOrder);
                    $orderKeyB = array_search($keyB, $correctKeysOrder);
                    return $orderKeyA > $orderKeyB;
                });
        });
        return $dajesByDate;
    }
}