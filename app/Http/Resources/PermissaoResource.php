<?php

namespace App\Http\Resources;

class PermissaoResource extends GlobalResource
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
            "user" => $this->user,
            "tabela" => $this->tabela,
            "tipoPermissao" => $this->tipoPermissao,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
