<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\PetService;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PetServicePolicy
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
     * @param  \App\Models\PetService  $petService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PetService $petService)
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
        return $user->hasPermission(PermissionEnum::CREATE_PET_SERVICE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PetService  $petService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PetService $petService)
    {
        return $user->hasPermission(PermissionEnum::UPDATE_PET_SERVICE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PetService  $petService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PetService $petService)
    {
        return $user->hasPermission(PermissionEnum::DELETE_PET_SERVICE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PetService  $petService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PetService $petService)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PetService  $petService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PetService $petService)
    {
        //
    }
}
