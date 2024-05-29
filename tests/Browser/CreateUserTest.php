<?php

namespace Tests\Browser;

use App\Enums\RoleEnum;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserCreate()
    {
        Role::factory()->create([
            'role_id' => RoleEnum::ADMIN,
            'role_name' => 'Admin',
        ]);
        Role::factory()->create([
            'role_id' => RoleEnum::EMPLOYEE,
            'role_name' => 'employee',
        ]);

        Branch::factory()->create(
            [
                'branch_id' => 1,
                'branch_name' => 'Ha Noi',
                'branch_phone' => '0919520565',
            ]
        );

        Branch::factory()->create(
            [
                'branch_id' => 2,
                'branch_name' => 'HCM',
                'branch_phone' => '0919520564',
            ]
        );
        $admin = User::factory()->create([
            'role_id' => RoleEnum::ADMIN,
            'is_active' => 1,
            'user_email' => '0uQpI@example.com',
            'username' => 'abc',
        ]);

        $employee = User::factory()->create([
            'role_id' => RoleEnum::EMPLOYEE,
            'is_active' => 1,
            'user_email' => '0uQpI123@example.com',
            'username' => 'xyzas',

        ]);

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('user.create'))->assertSee('Create User')
                ->attach('user_avatar', storage_path('\testing\test-image.png'))
                ->type('user_first_name', 'Hoàng')
                ->type('user_last_name', 'Lê')
                ->type('user_email', 'nKjQh@example.com')
                ->type('user_password', '123456789')
                ->type('user_password_confirmation', '123456789')
                ->type('username', 'hoangthai789')
                ->type('user_phone_number', '0123456789')
                ->radio('user_gender', '1')
                ->type('user_address', '123 Test street')
                ->select('role_id', RoleEnum::EMPLOYEE)
                ->keys('#birthdate', 2)
                ->keys('#birthdate', 8)
                ->keys('#birthdate', 2001)
                ->select('branch_id', '2')
                ->check('is_active')
                ->press('#submit-btn')
                ->assertSee('Success! User created successfully')
                ->pause(15000);
        });

        $this->browse(function ($browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit(route('user.create'))->assertSee('Create User')
                ->attach('user_avatar', storage_path('\testing\test-large-image.jpg'))
                ->type('user_first_name', 'H')
                ->type('user_last_name', 'L')
                ->type('user_email', 'nKjQh@example.com')
                ->type('user_password', '123456789')
                ->type('user_password_confirmation', '02345679')
                ->type('username', 'hoangthai789')
                ->type('user_phone_number', '0123456789')
                ->radio('user_gender', '1')
                ->type('user_address', '123 Test street')
                ->select('role_id', RoleEnum::EMPLOYEE)
                ->keys('#birthdate', 2)
                ->keys('#birthdate', 8)
                ->keys('#birthdate', 2018)
                ->select('branch_id', '2')
                ->check('is_active')
                ->press('#submit-btn')
                ->assertSee('The user first name must be at least 2 characters.')
                ->assertSee('The user last name must be at least 2 characters.')
                ->assertSee('The Username has already been taken.')
                ->assertSee('The user email has already been taken.')
                ->assertSee('The user birthdate must be a date before 2016-05-28.')
                ->assertSee('The user password confirmation does not match.');
        });

        $this->browse(function ($browser) use ($employee) {
            $browser->loginAs($employee)
                ->visit(route('user.create'))->assertSee('Create User')
                ->type('user_first_name', 'Hoàng')
                ->type('user_last_name', 'Lê')
                ->type('user_email', 'testKjQh@example.com')
                ->type('user_password', '123456789')
                ->type('user_password_confirmation', '123456789')
                ->type('username', 'hoangthai7899')
                ->radio('user_gender', '1')
                ->type('user_address', '123 Test street')
                ->select('role_id', RoleEnum::EMPLOYEE)
                ->select('branch_id', '2')
                ->check('is_active')
                ->press('#submit-btn')
                ->assertSee('Error! You do not have permission to create user')
                ->pause(1000);
        });
    }
}
