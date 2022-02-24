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
        return [
            "id" => $this->id,
            "numero" => $this->numero,
            "processo" => $this->processo,
            "parteAdversa" => $this->parte_adversa,
            "valor" => $this->valor,
            "emissao" => $this->emissao,
            "vencimento" => $this->vencimento,
            "tipo" => $this->tipo,
            "qtdAtos" => $this->qtd_atos,
            "eventosAtos" => $this->eventos_atos,
            "gerencia" => $this->gerencia,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
