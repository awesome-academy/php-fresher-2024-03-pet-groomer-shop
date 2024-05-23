<?php

namespace App\Policies;

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
        return $user->role_id === RoleEnum::ADMIN || $user->role_id === RoleEnum::MANGER;
    }

    public function update(User $user, Pet $pet)
    {
        return $user->role_id === RoleEnum::ADMIN || $user->role_id === RoleEnum::MANGER
            || $user->user_id === $pet->user_id;
    }

    public function delete(User $user, Pet $pet)
    {
        return $user->role_id === RoleEnum::ADMIN || $user->role_id === RoleEnum::MANGER
            || $user->user_id === $pet->user_id;
    }
}
