<?php

namespace App\Http\Resources;

class GeneroResource extends GlobalResource
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
            "nome" => $this->genero,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
