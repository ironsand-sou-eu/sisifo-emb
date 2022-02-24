<?php

namespace App\Http\Resources;

class TabelaResource extends GlobalResource
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
            "nome" => $this->nome_tabela,
            "nomeParaExibicao" => $this->nome_exibicao,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
