<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateInitialAdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();

        User::create([
            'user_first_name' => 'Nguyễn Hoàng',
            'user_last_name' => 'Thái',
            'user_email' => 'admin@sun-asterisk.com',
            'is_active' => 1,
            'username' => 'admin-account',
            'user_password' => Hash::make('12345678'),
            'is_admin' => 1,
            'user_gender' => 0,
            'user_birthdate' => '2001-08-20',
            'email_verified_at' => now(),
            'user_phone_number' => '0919520565',
            'user_address' => 'HCM',
            'role_id' => 1,
        ]);
    }
}
