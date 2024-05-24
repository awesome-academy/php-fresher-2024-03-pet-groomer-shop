<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role_id === RoleEnum::ADMIN || $user->role_id === RoleEnum::MANGER;
    }

    public function updateAdmin(User $user, User $model)
    {
        return $user->role_id === RoleEnum::ADMIN && $model->admin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        $this->checkManagerAndAdmin($user, $model);

        return $user->role_id === RoleEnum::ADMIN || $user->role_id === RoleEnum::MANGER;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        if ($user->user_id === $model->user_id) {
            return false;
        }

        $this->checkManagerAndAdmin($user, $model);

        return true;
    }

    public function deleteAdmin(User $user, User $model)
    {
        return $user->role_id === RoleEnum::ADMIN && $model->admin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    public function assignTask(User $user, User $model)
    {
        return $user->role_id === RoleEnum::ADMIN || $user->role_id === RoleEnum::MANGER;
    }

    public function unassignTask(User $user, User $model)
    {
        return $user->role_id === RoleEnum::ADMIN || $user->role_id === RoleEnum::MANGER;
    }

    private function checkManagerAndAdmin(User $user, User $model)
    {
        if ($user->role_id === RoleEnum::MANGER && $model->role_id === RoleEnum::ADMIN) {
            return false;
        }
    }
}
