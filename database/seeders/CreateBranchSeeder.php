<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class CreateBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'branch_name' => 'Pet Groomer Shop Dien Bien Phu',
                'branch_address' => '123, Dien Bien Phu, District 3, HCM City',
                'branch_phone' => '0919520565',
            ],

            [
                'branch_name' => 'Pet Groomer Shop Nguyen Van Cu',
                'branch_address' => '56, Nguyen Van Cu , District 5, HCM City',
                'branch_phone' => '0919520544',
            ],

        ];

        foreach ($branches as $branch) {
            Branch::create([
                'branch_name' => $branch['branch_name'],
                'branch_address' => $branch['branch_address'],
                'branch_phone' => $branch['branch_phone'],
                'created_by' => 1,
            ]);
        }
    }
}
