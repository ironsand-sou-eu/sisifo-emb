<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daje extends Model
{
    use HasFactory;
    
    protected $table = "dajes_gerados";
    protected $primarykey = "id";
    protected $fillable = [
        "numero",
        "processo",
        "parte_adversa",
        "valor",
        "emissao",
        "vencimento",
        "tipo",
        "qtd_atos",
        "eventos_atos",
        "gerencia"
    ];
}