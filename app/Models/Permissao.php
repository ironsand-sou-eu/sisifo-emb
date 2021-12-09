<?php

namespace App\Models;

use App\Models\Core\User;
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
}