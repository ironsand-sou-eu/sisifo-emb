<?php

namespace App\Models\Access;

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

    public static $validationRules = [
        "nome_permissao" => ["required", "max:10", "unique:tipos_permissoes"],
    ];
}
