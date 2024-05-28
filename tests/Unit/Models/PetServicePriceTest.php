<?php

namespace Tests\Unit\Models;

use App\Models\PetServicePrice;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\Unit\ModelTestCase;

class PetServicePriceTest extends ModelTestCase
{
    protected $petServicePrice;

    protected function setUp(): void
    {
        parent::setUp();
        $this->petServicePrice =
            PetServicePrice::factory()
            ->make([
                'pet_service_id' => 1,
                'pet_service_price' => 30.00,
                'pet_service_weight' => 5,
            ]);
    }

    protected function tearDown(): void
    {
        unset($this->petServicePrice);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            PetServicePrice::class,
            [],
            [],
            [],
            [],
            ['pet_service_price_id' => 'int', 'deleted_at' => 'datetime'],
            ['created_at', 'updated_at'],
            null,
            'pet_service_prices',
            'pet_service_price_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->petServicePrice->createdBy());
        $this->assertEquals('created_by', $this->petServicePrice->createdBy()->getForeignKeyName());
        $this->assertEquals('user_id', $this->petServicePrice->createdBy()->getOwnerKeyName());

        $this->assertInstanceOf(BelongsTo::class, $this->petServicePrice->petService());
        $this->assertEquals('pet_service_id', $this->petServicePrice->petService()->getForeignKeyName());
        $this->assertEquals('pet_service_id', $this->petServicePrice->petService()->getOwnerKeyName());
    }

    public function testPriceFormatAttribute()
    {
        $this->petServicePrice->pet_service_price = 1000;
        $this->assertEquals('1.000 VND', $this->petServicePrice->price_format);
    }

    public function testWeightFormatAttribute()
    {
        $this->petServicePrice->pet_service_weight = 10;
        $this->assertEquals('10 KG', $this->petServicePrice->weight_format);
    }
}
