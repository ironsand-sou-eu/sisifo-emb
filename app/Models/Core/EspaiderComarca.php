<?php

namespace App\Models\Core;

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
        return $this->belongsTo(EspaiderUf::class);
    }

    public function espaiderJuizos() {
        return $this->hasMany(EspaiderJuizo::class);
    }

    public function eseloComarcas() {
        return $this->hasMany(EseloComarca::class);
    }
}
