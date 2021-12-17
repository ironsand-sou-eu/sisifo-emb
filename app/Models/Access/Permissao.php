<?php

namespace App\Models\Access;

use App\Models\BizRules\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $table = "permissoes";
    protected $primarykey = "id";
    protected $fillable = [
        "user_id",
        "tabela_id",
        "tipo_permissao_id"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tabela() {
        return $this->belongsTo(Tabela::class);
    }
    
    public function tipoPermissao() {
        return $this->belongsTo(TipoPermissao::class);
    }

    public static $validationRules = [
        "user_id" => ["required", "numeric"],
        "tabela_id" => ["required", "numeric"],
        "tipo_permissao_id" => ["required", "numeric"]
    ];
}