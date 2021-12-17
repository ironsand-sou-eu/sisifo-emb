<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspaiderJuizo extends Model
{
    use HasFactory;

    protected $table = "espaider_juizos";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_juizo_espaider",
        "redacao_cabecalho_juizo",
        "redacao_resumida_juizo",
        "espaider_comarca_id",
        "espaider_orgao_id"
    ];

    public function espaiderComarca() {
        return $this->belongsTo(EspaiderComarca::class);
    }

    public function espaiderOrgao() {
        return $this->belongsTo(EspaiderOrgao::class);
    }

    public function eseloJuizos() {
        return $this->hasMany(EseloJuizo::class);
    }

    public function sistemasJudJuizos() {
        return $this->hasMany(SistemasJudJuizo::class);
    }

    public static $validationRules = [
        "nome_juizo_espaider" => ["required", "min:5", "max:120", "unique:espaider_juizos"],
        "redacao_cabecalho_juizo" => ["required", "max:150"],
        "redacao_resumida_juizo" => ["required", "max:60"],
        "espaider_comarca_id" => ["required", "numeric"],
        "espaider_orgao_id" => ["required", "numeric"]
    ];
}