<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabela extends Model
{
    use HasFactory;

    protected $table = "tabelas";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_tabela"
    ];

    public function permissoes() {
        return $this->hasMany(Permissao::class);
    }

    public function campos() {
        return $this->hasMany(Campo::class);
    }
}
