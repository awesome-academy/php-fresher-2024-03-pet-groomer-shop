<?php

namespace Tests\Unit\Models;

use App\Models\HotelService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\Unit\ModelTestCase;

class HotelServiceTest extends ModelTestCase
{
    protected $hotelService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hotelService = HotelService::factory()->make(['order_id' => 1, 'hotel_price' => 100000]);
    }

    protected function tearDown(): void
    {
        unset($this->hotelService);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            HotelService::class,
            [],
            [],
            [],
            [],
            ['hotel_service_id' => 'int', 'is_active' => 'boolean'],
            ['created_at', 'updated_at'],
            null,
            'hotel_services',
            'hotel_service_id'
        );
    }

    public function testCareOrderRelationship()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->hotelService->careOrder());
        $this->assertEquals('order_id', $this->hotelService->careOrder()->getForeignKeyName());
        $this->assertEquals('order_id', $this->hotelService->careOrder()->getOwnerKeyName());
    }
}
