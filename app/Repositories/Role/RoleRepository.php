<?php

namespace App\Repositories\Role;

use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Role::class;
    }

    public function getRoleOption(bool $extra = false)
    {
        $roles = $this->model->pluck('role_id', 'role_name');
        if ($extra) {
            $roles[__('All')] = '';
        }

        return $roles;
    }
}
