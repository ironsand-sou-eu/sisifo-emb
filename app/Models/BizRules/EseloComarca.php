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
        "nome_comarca_eselo"
    ];

    public function eseloJuizos() {
        return $this->hasMany(EseloJuizo::class);
    }

    public static $validationRules = [
        "nome_comarca_eselo" => ["required", "min:2", "max:40", "unique:eselo_comarcas"]
    ];
}
