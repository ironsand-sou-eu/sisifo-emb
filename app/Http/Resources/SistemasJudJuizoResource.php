<?php

namespace App\Http\Resources;

class SistemasJudJuizoResource extends GlobalResource
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
            "nome" => $this->nome_juizo_sistemas_jud,
            "espaiderJuizo" => $this->espaiderJuizo,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
