<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspaiderOrgao extends Model
{
    use HasFactory;

    protected $table = "espaider_orgaos";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_orgao_espaider",
        "sigla_orgao"
    ];

    public function espaiderJuizos() {
        return $this->hasMany(EspaiderJuizo::class);
    }
}
