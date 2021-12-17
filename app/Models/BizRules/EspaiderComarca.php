<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspaiderComarca extends Model
{
    use HasFactory;

    protected $table = "espaider_comarcas";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_comarca_espaider",
        "espaider_uf_id"
    ];

    public function espaiderUf() {
        return $this->belongsTo(EspaiderUf::class, "espaider_uf_id", "sigla");
    }

    public function espaiderJuizos() {
        return $this->hasMany(EspaiderJuizo::class);
    }

    public static $validationRules = [
        "nome_comarca_espaider" => ["required", "min:2", "max:40"],
        "espaider_uf_id" => ["required", "size:2"]
    ];
}
