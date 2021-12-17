<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EseloJuizo extends Model
{
    use HasFactory;

    protected $table = "eselo_juizos";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_juizo_eselo",
        "eselo_comarca_id",
        "espaider_juizo_id"
    ];

    public function eseloComarca() {
        return $this->belongsTo(EseloComarca::class);
    }

    public function espaiderJuizo() {
        return $this->belongsTo(EspaiderJuizo::class);
    }

    public static $validationRules = [
        "nome_juizo_eselo" => ["required", "min:2", "max:150", "unique:eselo_juizos"],
        "eselo_comarca_id" => ["required", "numeric"],
        "espaider_juizo_id" => ["required", "numeric"]
    ];
}
