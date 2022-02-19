<?php

namespace App\Models\Access;

use App\Models\Access\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';

    protected $primarykey = 'id';

    protected $fillable = [
        'genero',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'genero_declarado_id');
    }
}
