<?php

namespace App\Policies;

use App\Models\Access\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Access\Permissao;
use App\Models\Access\Tabela;
use App\Models\Access\TipoPermissao;

class UsersPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Access\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Access\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Access\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $user = User::with('permissoes', 'permissoes.tabela', 'permissoes.tipoPermissao')->find($user->id);
        $usersTabela = Tabela::where('nome_tabela', 'users')->first();
        $createTipoPermissao = TipoPermissao::where('nome_permissao', 'criação')->first();
        $adminTipoPermissao = TipoPermissao::where('nome_permissao', 'catchanga')->first();
        $permissao = Permissao::with('tipoPermissao')
                    ->where('user_id', $user->id)
                    ->where('tabela_id', $usersTabela->id)
                    ->where(function($query) use ($createTipoPermissao, $adminTipoPermissao) {
                        $query->where('tipo_permissao_id', $createTipoPermissao->id)
                            ->orWhere('tipo_permissao_id', $adminTipoPermissao->id);
                    })
                    ->first();
        return (bool)$permissao;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Access\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Access\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Access\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Access\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
