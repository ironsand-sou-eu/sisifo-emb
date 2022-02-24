<?php

namespace App\Http\Resources;

class EseloComarcaResource extends GlobalResource
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
            "nomeComarcaEselo" => $this->nome_comarca_eselo,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
