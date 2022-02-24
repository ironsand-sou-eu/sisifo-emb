<?php

namespace App\Http\Resources;

class UserResource extends GlobalResource
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
            "nomeCompleto" => $this->nome_completo,
            "nomeEscolhido" => $this->nome_escolhido,
            "email" => $this->email,
            "emailVerifiedAt" => $this->email_verified_at,
            "ativo" => $this->ativo,
            "avatarPathname" => $this->avatar_path,
            "generoDeclarado" => $this->generoDeclarado,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at
        ];
    }
}
