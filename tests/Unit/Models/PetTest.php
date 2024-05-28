<?php

namespace Tests\Unit\Models;

use App\Enums\PetTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Tests\Unit\ModelTestCase;

class PetTest extends ModelTestCase
{
    protected $pet;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pet = Pet::factory()
            ->make([
                'pet_id' => 1,
                'pet_name' => 'Buddy',
                'pet_type' => PetTypeEnum::DOG,
                'pet_description' => 'A friendly dog',
                'pet_gender' => 1,
                'pet_weight' => 20.5,
                'pet_birthdate' => '2020-01-01',
                'breed_id' => 1,
                'user_id' => 1,
                'is_active' => 1,
            ]);
        $this->user = User::factory()->make([
            'user_id' => 1,
            'role_id' => 1,
        ]);
    }

    protected function tearDown(): void
    {
        unset($this->pet);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            Pet::class,
            [
                'pet_name',
                'pet_type',
                'pet_description',
                'pet_gender',
                'pet_weight',
                'pet_birthdate',
                'breed_id',
                'user_id',
                'is_active',
            ],
            ['*'],
            [],
            [],
            [
                'pet_birthdate' => 'date',
                'pet_id' => 'int',
                'deleted_at' => 'datetime',
            ],
            ['created_at', 'updated_at'],
            null,
            'pets',
            'pet_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->pet->user());
        $this->assertEquals('user_id', $this->pet->user()->getForeignKeyName());
        $this->assertEquals('user_id', $this->pet->user()->getOwnerKeyName());

        $this->assertInstanceOf(MorphOne::class, $this->pet->image());
        $this->assertEquals('imageable_type', $this->pet->image()->getMorphType());

        $this->assertInstanceOf(BelongsTo::class, $this->pet->breed());
        $this->assertEquals('breed_id', $this->pet->breed()->getForeignKeyName());
        $this->assertEquals('breed_id', $this->pet->breed()->getOwnerKeyName());

        $this->assertInstanceOf(BelongsTo::class, $this->pet->createdBy());
        $this->assertEquals('created_by', $this->pet->createdBy()->getForeignKeyName());
        $this->assertEquals('user_id', $this->pet->createdBy()->getOwnerKeyName());

        $this->assertInstanceOf(HasMany::class, $this->pet->careOrders());
        $this->assertEquals('pet_id', $this->pet->careOrders()->getForeignKeyName());
        $this->assertEquals('pet_id', $this->pet->careOrders()->getLocalKeyName());
    }

    public function testGetIsActiveNameAttribute()
    {
        $this->assertEquals(StatusEnum::getTranslated()[$this->pet->is_active], $this->pet->is_active_name);
    }

    public function testGetWeightNameAttribute()
    {
        $this->assertEquals(formatNumber($this->pet->pet_weight, 'KG'), $this->pet->weight_name);
    }

    public function testGetPetTypeNameAttribute()
    {
        $this->assertEquals(PetTypeEnum::getTranslated()[$this->pet->pet_type], $this->pet->pet_type_name);
    }

    public function testCheckOwner()
    {
        $this->actingAs($this->user);
        $this->assertTrue($this->pet->checkOwner());
    }
}
