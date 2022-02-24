<?php

namespace App\Http\Resources;

class LogAlteracaoResource extends GlobalResource
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
            "campo" => $this->campo,
            "valorAnterior" => $this->valor_anterior,
            "valorAtual" => $this->valor_atual,
            "dataAlteracao" => $this->data_alteracao,
            "alteradoPor" => $this->alteradoPor,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
