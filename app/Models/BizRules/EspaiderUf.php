<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspaiderUf extends Model
{
    use HasFactory;

    protected $table = "espaider_ufs";
    protected $primarykey = "sigla_uf";
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = [
        "nome_uf_espaider",
        "sigla_uf"
    ];

    public function espaiderComarcas() {
        return $this->hasMany(EspaiderComarca::class);
    }
}
