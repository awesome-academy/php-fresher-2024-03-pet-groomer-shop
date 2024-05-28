<?php

namespace Tests\Unit\Models;

use App\Enums\PetTypeEnum;
use App\Models\Breed;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\ModelTestCase;

class BreedTest extends ModelTestCase
{
    protected $breed;

    protected function setUp(): void
    {
        parent::setUp();
        $this->breed = Breed::factory()
            ->make([
                'breed_id' => 1,
                'breed_name' => 'Chó Mỹ',
                'breed_type' => PetTypeEnum::DOG,
            ]);
    }

    protected function tearDown(): void
    {
        unset($this->breed);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            Breed::class,
            [],
            [],
            [],
            [],
            ['breed_id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'breeds',
            'breed_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(HasMany::class, $this->breed->pets());
        $this->assertEquals('breed_id', $this->breed->pets()->getForeignKeyName());
        $this->assertEquals('breed_id', $this->breed->pets()->getLocalKeyName());

        $this->assertInstanceOf(BelongsTo::class, $this->breed->createdBy());
        $this->assertEquals('created_by', $this->breed->createdBy()->getForeignKeyName());
        $this->assertEquals('user_id', $this->breed->createdBy()->getOwnerKeyName());
    }

    public function testGetBreedTypeNameAttribute()
    {
        $this->assertEquals('Dog', $this->breed->breed_type_name);
    }
}
