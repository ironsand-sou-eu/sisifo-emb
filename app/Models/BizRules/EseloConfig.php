<?php

namespace App\Models\BizRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EseloConfig extends Model
{
    use HasFactory;

    protected $table = 'eselo_configs';

    protected $primarykey = 'id';

    protected $fillable = [
        'nome',
        'valor',
    ];
}
