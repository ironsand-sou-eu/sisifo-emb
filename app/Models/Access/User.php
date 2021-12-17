<?php

namespace App\Models\Access;

use App\Models\Access\Genero;
use App\Models\Access\Permissao;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nome_completo',
        'nome_escolhido',
        'genero_declarado_id',
        'email',
        'password',
        'ativo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function genero_declarado() {
        return $this->belongsTo(Genero::class, "genero_declarado_id");
    }

    public function permissoes() {
        return $this->hasMany(Permissao::class);
    }

    public function camposAlterados() {
        return $this->hasMany(LogAlteracao::class, "alterado_por");
    }

    public static $validationRules = [
        "nome_completo" => ["required", "min:5", "max:100"],
        "nome_escolhido" => ["nullable", "min:2", "max:100"],
        "genero_declarado_id" => ["required", "numeric"],
        "email" => ["required", "email", "unique:users"],
        "email_verified_at" => ["nullable", "date"],
        "password" => ["required"],
        "remember_token" => ["nullable", "max:100"],
        "ativo" => ["required", "boolean"]
    ];
}