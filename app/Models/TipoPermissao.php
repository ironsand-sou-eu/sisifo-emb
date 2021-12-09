<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPermissao extends Model
{
    use HasFactory;

    protected $table = "tipos_permissoes";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_permissao"
    ];

    public function permissoes() {
        return $this->hasMany(Permissao::class);
    }
}
