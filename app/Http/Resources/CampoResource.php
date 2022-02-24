<?php

namespace App\Http\Resources;

class CampoResource extends GlobalResource
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
            "nomeCampo" => $this->nome_campo,
            "nomeExibicao" => $this->nome_exibicao,
            "tabela" => $this->tabela,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
