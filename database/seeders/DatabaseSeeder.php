<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // for seeder file
        $this->call([
            CreateInitialRoleSeeder::class,
            CreateInitialAdminAccountSeeder::class,
            CreateBranchSeeder::class,
        ]);

        //for model factory file
        User::factory(10)->create();
        Pet::factory(100)->create();
        Coupon::factory(10)->create();
    }
}
