<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class CreateInitialRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'manager',
            'employee',
            'customer',
        ];

        foreach ($roles as $role) {
            Role::create([
                'role_name' => $role,
            ]);
        }
    }
}
