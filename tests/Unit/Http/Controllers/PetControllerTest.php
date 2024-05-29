<?php

namespace Tests\Unit\Http\Controllers;

use App\Enums\PetTypeEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\PetController;
use App\Http\Requests\PetRequest;
use App\Http\Requests\Search\PetSearchRequest;
use App\Models\Pet;
use App\Models\User;
use App\Repositories\Breed\BreedRepository;
use App\Repositories\Pet\PetRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class PetControllerTest extends TestCase
{
    protected $controller;
    protected $mockPetRepo;

    protected $petTypes;
    protected $petTypesSelected;
    protected $petTypesSelectedExtra;

    protected $admin;
    protected $employee;
    protected $breed;
    protected $role;
    protected $user;
    protected $pet;
    protected $mockBreedRepo;
    protected $mockRoleRepo;
    protected $mockUserRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockPetRepo = Mockery::mock(PetRepository::class);
        $this->mockBreedRepo = Mockery::mock(BreedRepository::class);
        $this->mockRoleRepo = Mockery::mock(RoleRepository::class);
        $this->mockUserRepo = Mockery::mock(UserRepository::class);

        $this->controller = new PetController(
            $this->mockPetRepo,
            $this->mockBreedRepo,
            $this->mockRoleRepo,
            $this->mockUserRepo
        );

        $this->petTypes = PetTypeEnum::getTranslated();
        $this->petTypesSelected = array_flip($this->petTypes);
        $this->petTypesSelectedExtra = $this->petTypesSelected;
        $this->petTypesSelectedExtra[__('All')] = '';

        $this->admin = User::factory()
            ->make([
                'user_id' => 1,
                'user_first_name' => 'admin',
                'user_last_name' => 'test',
                'role_id' => RoleEnum::ADMIN,
            ]);

        $this->employee = User::factory()
            ->make([
                'user_id' => 2,
                'user_first_name' => 'employee',
                'user_last_name' => 'test',
                'role_id' => RoleEnum::EMPLOYEE,
            ]);

        $this->pet = Pet::factory()->make([
            'pet_id' => 1,
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 0,
            'user_id' => $this->admin->user_id,
        ]);
    }

    public function tearDown(): void
    {
        $this->admin->delete();
        $this->employee->delete();
        unset($this->controller);
        unset($this->mockPetRepo);
        unset($this->mockBreedRepo);
        unset($this->mockRoleRepo);
        unset($this->mockUserRepo);
        unset($this->petTypes);
        unset($this->petTypesSelected);
        unset($this->petTypesSelectedExtra);
        unset($this->admin);
        unset($this->employee);
        unset($this->pet);
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_function_return_view()
    {
        $this->mockPetRepo->shouldReceive('getPetList')->andReturn(collect(['user1', 'user2']));
        $this->mockBreedRepo->shouldReceive('getBreedOption')->once()->andReturnSelf();
        $this->testPetOptions();
        $request = new PetSearchRequest([]);

        $response = $this->controller->index($request);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_create_return_view()
    {
        $this->testPetOptions();
        $this->mockBreedRepo->shouldReceive('getBreedOption')->once()->andReturnSelf();
        $this->mockRoleRepo->shouldReceive('getRoleOption')->once()->andReturnSelf();
        $this->mockUserRepo->shouldReceive('getUserOption')->once();

        $response = $this->controller->create();
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_store_return_success_with_user_id_input()
    {
        $this->actingAs($this->admin);
        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 0,
            'user_id' => 1,
        ]);

        $this->mockPetRepo->shouldReceive('storePet');

        $response = $this->controller->store($request, 1);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(__('Pet created successfully'), session('success'));
    }

    public function test_store_return_success_without_user_id_input()
    {
        $this->actingAs($this->admin);

        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 0,
        ]);

        $this->mockPetRepo->shouldReceive('storePet');

        $response = $this->controller->store($request, 1);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_store_return_error_exists_breed()
    {
        $this->actingAs($this->admin);
        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 1,
        ]);

        $this->mockPetRepo->shouldReceive('storePet');

        $response = $this->controller->store($request, 1);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_store_return_error_not_admin()
    {
        $this->actingAs($this->employee);

        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 0,
        ]);

        $this->mockPetRepo->shouldReceive('storePet');

        $response = $this->controller->store($request, 1);

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_update_return_success()
    {
        $this->actingAs($this->admin);

        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 0,
        ]);
        $this->mockPetRepo->shouldReceive('updatePet');
        $response = $this->controller->update(
            $request,
            $this->pet->pet_id,
            $this->admin->user_id
        );
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(__('Pet updated successfully'), session('success'));
    }

    public function test_update_return_success_with_redirect_input()
    {
        $this->actingAs($this->admin);

        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 0,
            'redirect_pet_index' => 1,
        ]);
        $this->mockPetRepo->shouldReceive('updatePet');
        $response = $this->controller->update(
            $request,
            $this->pet->pet_id,
            $this->admin->user_id
        );
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(__('Pet updated successfully'), session('success'));
    }

    public function test_update_return_error_with_employee()
    {
        $this->actingAs($this->employee);

        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 0,
            'redirect_pet_index' => 1,
        ]);
        $this->mockPetRepo->shouldReceive('updatePet');
        $response = $this->controller->update(
            $request,
            $this->pet->pet_id,
            $this->admin->user_id
        );
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_update_return_error_with_invalid_breedtype()
    {
        $this->actingAs($this->admin);

        $request = new PetRequest([
            'pet_name' => 'test pet',
            'pet_weight' => 12,
            'breed_id' => 1,
            'pet_type' => 1,
            'redirect_pet_index' => 1,
        ]);
        $this->mockPetRepo->shouldReceive('updatePet');
        $response = $this->controller->update(
            $request,
            $this->pet->pet_id,
            $this->admin->user_id
        );
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_delete_return_success()
    {
        $this->actingAs($this->admin);
        $this->mockPetRepo->shouldReceive('deletePet');
        $this->controller->destroy($this->pet->pet_id);
        $this->assertEquals(trans('Pet deleted successfully'), session('success'));
    }

    public function test_delete_return_error_not_admin()
    {
        $this->actingAs($this->employee);
        $this->mockPetRepo->shouldReceive('deletePet');
        $this->controller->destroy($this->pet->pet_id);
        $this->assertNotEquals(trans('Pet deleted successfully'), session('error'));
    }

    private function testPetOptions()
    {
        $this->mockPetRepo->shouldReceive('getPetOptions')
            ->andReturn([
                $this->petTypes,
                $this->petTypesSelected,
                $this->petTypesSelectedExtra,
            ]);
    }
}
