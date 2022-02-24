<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustasConfig extends Model
{
    use HasFactory;

    protected $table = 'custas_configs';

    protected $primarykey = 'id';

    protected $fillable = [
        'nome',
        'valor',
    ];
}
