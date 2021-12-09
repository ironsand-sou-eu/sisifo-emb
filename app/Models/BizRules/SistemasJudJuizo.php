<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemasJudJuizo extends Model
{
    use HasFactory;

    protected $table = "sistemas_jud_juizos";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_juizo_sistemas_jud",
        "espaider_juizo_id"
    ];

    public function espaiderJuizo() {
        return $this->belongsTo(EspaiderJuizo::class);
    }
}
