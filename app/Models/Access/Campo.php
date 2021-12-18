<?php

namespace App\Models\Access;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    use HasFactory;

    protected $table = "campos";
    protected $primarykey = "id";
    protected $fillable = [
        "nome_campo",
        "tabela_id"
    ];

    public function tabela() {
        return $this->belongsTo(Tabela::class);
    }

    public function logsAlteracoes() {
        return $this->hasMany(LogAlteracao::class);
    }
}
