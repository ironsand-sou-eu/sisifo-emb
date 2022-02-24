<?php

namespace App\Http\Resources;

class EspaiderJuizoResource extends GlobalResource
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
            "nome" => $this->nome_juizo_espaider,
            "slug" => $this->slug,
            "redacaoCabecalhoJuizo" => $this->redacao_cabecalho_juizo,
            "redacaoResumidaJuizo" => $this->redacao_resumida_juizo,
            "espaiderComarca" => $this->espaiderComarca,
            "espaiderOrgao" => $this->espaiderOrgao,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
