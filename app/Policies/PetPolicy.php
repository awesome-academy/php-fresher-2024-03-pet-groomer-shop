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

    public function delete(User $user, Pet $pet)
    {
        if ($user->hasPermission('delete-pet')) {
            return true;
        }

        return $user->user_id === $pet->user_id;
    }
}
