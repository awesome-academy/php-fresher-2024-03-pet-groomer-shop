<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PetPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->role_id === RoleEnum::ADMIN) {
            return true;
        }
    }

    public function create(User $user)
    {
        return $user->hasPermission(PermissionEnum::CREATE_PET);
    }

    public function update(User $user, Pet $pet)
    {
        return $user->hasPermission(PermissionEnum::UPDATE_PET) || $user->user_id === $pet->user_id;
    }

    public function delete(User $user, Pet $pet)
    {
        return $user->hasPermission(PermissionEnum::DELETE_PET) || $user->user_id === $pet->user_id;
    }
}
