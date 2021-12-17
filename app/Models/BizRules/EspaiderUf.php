<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspaiderUf extends Model
{
    use HasFactory;

    protected $table = "espaider_ufs";
    protected $primarykey = "sigla";
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = [
        "nome_uf_espaider",
        "sigla"
    ];

    public function espaiderComarcas() {
        return $this->hasMany(EspaiderComarca::class);
    }

    public static $validationRules = [
        "nome_uf_espaider" => ["required", "min:4", "max:25", "unique:espaider_ufs"],
        "sigla" => ["required", "regex:/^[A-Z]{2}$/", "unique:espaider_ufs"],
    ];
}
