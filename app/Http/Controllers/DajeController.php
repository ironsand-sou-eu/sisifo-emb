<?php

namespace App\Http\Controllers;

use App\Models\BizRules\Daje;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DajesExport;

class DajeController extends Controller
{
    protected $mainModel = \App\Models\BizRules\Daje::class;

    protected $displayFields = [
        0 => ['name' => 'numero', 'caption' => 'Númerodo DAJE', 'inputType' => 'text'],
        1 => ['name' => 'processo', 'caption' => 'Número do processo', 'inputType' => 'text'],
        2 => ['name' => 'parte_adversa', 'caption' => 'Nome do adverso', 'inputType' => 'text'],
        3 => ['name' => 'valor', 'caption' => 'Valor do DAJE', 'inputType' => 'text'],
        4 => ['name' => 'emissao', 'caption' => 'Data de emissão', 'inputType' => 'date'],
        5 => ['name' => 'vencimento', 'caption' => 'Data de vencimento', 'inputType' => 'date'],
        6 => ['name' => 'tipo', 'caption' => 'Tipo de DAJE', 'inputType' => 'text'],
        7 => ['name' => 'qtd_atos', 'caption' => 'Quantidade de atos', 'inputType' => 'text'],
        8 => ['name' => 'eventos_atos', 'caption' => 'Eventos/valores dos atos', 'inputType' => 'text'],
        9 => ['name' => 'codigo_barras', 'caption' => 'Código de barras', 'inputType' => 'text'],
        10 => ['name' => 'gerencia', 'caption' => 'Gerência', 'inputType' => 'text'],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'title' => 'Dajes gerados',
            'description' => 'Consulta de DAJEs gerados pelo Sísifo DAJEs',
            'url' => url('/dajes'),
            'apiUrl' => url('/api/dajes'),
            'dbFieldNames' => [
                'numero',
                'processo',
                'parteAdversa',
                'valor',
                'emissao',
                'vencimento',
                'tipo',
                'qtdAtos',
                'eventosAtos',
                'codigoBarras',
                'gerencia',
            ],
            'dbNameField' => 'numero',
            'dbIdField' => 'id',
            'tableColumnNames' => [
                'Número do DAJE',
                'Número do processo',
                'Nome do adverso',
                'Valor do DAJE',
                'Data de emissão',
                'Data de vencimento',
                'Tipo de DAJE',
                'Quantidade de atos',
                'Números dos evento dos atos',
                'Código de barras',
                'Gerência',
            ],
        ];
        return $this->generalIndex($request, $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'numero' => ['required', 'unique:dajes_gerados'],
            'processo' => ['required'],
            'parte_adversa' => ['string'],
            'valor' => ['required', 'numeric'],
            'emissao' => ['required', 'date'],
            'vencimento' => ['required', 'date'],
            'tipo' => ['required'],
            'qtd_atos' => ['required'],
            'eventos_atos' => ['nullable'],
            'codigo_barras' => ['nullable', 'string'],
            'gerencia' => ['required'],
        ];

        return $this->validateAndStore($request, $this->mainModel, $validationRules);
    }

    /**
     * Open resource's creation form in frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\View
     */
    public function create(Request $request)
    {
        if ($this->isApiRoute($request)) {
            return response('', 404);
        }

        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Novo DAJE',
            'description' => 'Evite registrar DAJEs manualmente no Sísifo. O ideal é fazê-lo utilizando '.
                'o Sísifo Custas',
            'url' => url('/dajes'),
            'apiUrl' => url('/api/dajes'),
            'displayFields' => $this->displayFields,
        ];

        return view('components.new', $params);
    }

    /**
     * Open the specified resource for edition in frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Illuminate\Support\Facades\View
     */
    public function edit(Request $request, $id)
    {
        if ($this->isApiRoute($request)) {
            return response('', 404);
        }

        $entity = $this->mainModel::find($id);
        $params = [
            'jwt' => $request->cookie('jat'),
            'title' => 'Editando DAJE',
            'description' => 'Só edite um DAJE se você tiver certeza de que isso não influenciará no controle.',
            'id' => $id,
            'url' => url('/dajes'),
            'apiUrl' => url('/api/dajes'),
            'entity' => $entity,
            'displayFields' => $this->displayFields,
        ];

        return view('components.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BizRules\Daje  $daje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validationRules = [
            'numero' => ['string'],
            'parte_adversa' => ['string'],
            'processo' => ['string'],
            'valor' => ['numeric'],
            'emissao' => ['date'],
            'vencimento' => ['date'],
            'tipo' => ['string'],
            'qtd_atos' => ['numeric'],
            'eventos_atos' => ['string'],
            'codigo_barras' => ['string'],
            'gerencia' => ['string'],
        ];

        return $this->validateAndUpdate($request, $this->mainModel, $id, $validationRules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BizRules\Daje  $daje
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->delete($this->mainModel, $id);
    }

    public function getDajesInfoForSap(Request $request) {
        $initialReportDate = $request->input('initialDate');
        $finalReportDate = $request->input('finalDate');
        $formattedDate = date('Y-m-d H-i-s');
        $reportName = "Sisifo - Relatorio DAJEs gerado $formattedDate.xlsx";
        return  Excel::download(new DajesExport($initialReportDate, $finalReportDate), $reportName);
    }
}
