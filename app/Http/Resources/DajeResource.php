<?php

namespace App\Http\Resources;

class DajeResource extends GlobalResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $emissionDate = date_create($this->emissao);
        $dueDate = date_create($this->vencimento);
        $value = number_format($this->valor, 2, ",", ".");
        $qtdAtos = $this->qtd_atos ?: "";

        return [
            "id" => $this->id,
            "numero" => $this->numero,
            "processo" => $this->processo,
            "parteAdversa" => $this->parte_adversa,
            "valor" => $value,
            "emissao" => date_format($emissionDate, 'd/m/Y'),
            "vencimento" => date_format($dueDate, 'd/m/Y'),
            "tipo" => $this->tipo,
            "qtdAtos" => $qtdAtos,
            "eventosAtos" => $this->eventos_atos,
            "codigoBarras" => $this->codigo_barras,
            "gerencia" => $this->gerencia,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
