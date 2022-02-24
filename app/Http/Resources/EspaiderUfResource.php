<?php

namespace App\Http\Resources;

class EspaiderUfResource extends GlobalResource
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
            "sigla" => $this->sigla,
            "nome" => $this->nome_uf_espaider,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
