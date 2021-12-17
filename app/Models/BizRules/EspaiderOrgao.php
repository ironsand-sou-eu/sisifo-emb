<?php

namespace App\Models\BizRules;

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

    public static $validationRules = [
        "nome_orgao_espaider" => ["required", "min:3", "max:90", "unique:espaider_orgaos"],
        "sigla_orgao" => ["required", "min:2", "max:25"],
    ];
}
