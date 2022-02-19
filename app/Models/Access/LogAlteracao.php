<?php

namespace App\Models\Access;

use App\Models\Access\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAlteracao extends Model
{
    use HasFactory;

    protected $table = 'log_alteracoes';

    protected $primarykey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'campo_id',
        'valor_anterior',
        'valor_atual',
        'data_alteracao',
        'alterado_por',
    ];

    public function campo()
    {
        return $this->belongsTo(Campo::class);
    }

    public function alteradoPor()
    {
        return $this->belongsTo(User::class, 'alterado_por');
    }
}
