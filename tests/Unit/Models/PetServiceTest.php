<?php

namespace Tests\Unit\Models;

use App\Models\PetService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\Unit\ModelTestCase;

class PetServiceTest extends ModelTestCase
{
    protected $petService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->petService = PetService::factory()->make(['pet_service_id' => 1, 'pet_service_name' => 'Bath']);
    }

    protected function tearDown(): void
    {
        unset($this->petService);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            PetService::class,
            [],
            [],
            [],
            [],
            ['pet_service_id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'pet_services',
            'pet_service_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->petService->createdBy());
        $this->assertEquals('created_by', $this->petService->createdBy()->getForeignKeyName());
        $this->assertEquals('user_id', $this->petService->createdBy()->getOwnerKeyName());

        $this->assertInstanceOf(HasMany::class, $this->petService->petServicePrice());
        $this->assertEquals('pet_service_id', $this->petService->petServicePrice()->getForeignKeyName());

        $this->assertInstanceOf(BelongsToMany::class, $this->petService->careOrderDetail());
        $this->assertEquals('pet_service_id', $this->petService->careOrderDetail()->getForeignPivotKeyName());
        $this->assertEquals('order_id', $this->petService->careOrderDetail()->getRelatedPivotKeyName());
        $this->assertArrayHasKey('pet_service_price', $this->petService->careOrderDetail()->getEagerLoads());
    }
}
