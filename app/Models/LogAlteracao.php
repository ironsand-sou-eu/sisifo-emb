<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAlteracao extends Model
{
    use HasFactory;

    protected $table = "log_alteracoes";
    protected $primarykey = "id";
    protected $fillable = [
        "campo_id",
        "data_alteracao",
        "valor_anterior",
        "valor_atual"
    ];

    public function campo() {
        return $this->belongsTo(Campo::class);
    }
}