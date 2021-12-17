<?php

namespace App\Models\Access;

use App\Models\BizRules\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAlteracao extends Model
{
    use HasFactory;

    protected $table = "log_alteracoes";
    protected $primarykey = "id";
    protected $fillable = [
        "campo_id",
        "valor_anterior",
        "valor_atual",
        "data_alteracao",
        "alterado_por"
    ];

    public function campo() {
        return $this->belongsTo(Campo::class);
    }

    public function alteradoPor() {
        return $this->belongsTo(User::class, "alterado_por");
    }

    public static $validationRules = [
        "campo_id" => ["required", "numeric"],
        "valor_anterior" => ["required", "max:150"],
        "valor_atual" => ["required", "max:150"],
        "data_alteracao" => ["required", "date"],
        "alterado_por" => ["required", "numeric"]
    ];
}