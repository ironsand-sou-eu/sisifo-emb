<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EseloComarca extends Model
{
    use HasFactory;

    protected $table = "eselo_comarcas";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_comarca_eselo",
        "espaider_comarca_id"
    ];

    public function eseloJuizos() {
        return $this->hasMany(EseloJuizo::class);
    }
}
