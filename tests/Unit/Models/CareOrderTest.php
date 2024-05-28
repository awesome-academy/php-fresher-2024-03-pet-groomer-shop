<?php

namespace Tests\Unit\Models;

use App\Enums\OrderStatusEnum;
use App\Models\CareOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\Unit\ModelTestCase;

class CareOrderTest extends ModelTestCase
{
    protected $careOrder;
    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->careOrder = CareOrder::factory()->make([
            'order_id' => 1,
            'branch_id' => 1,
            'user_id' => 1,
            'pet_id' => 1,
            'order_status' => OrderStatusEnum::CONFIRMED,
            'order_total_price' => 100000,
        ]);
        $this->user = User::factory()->make([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        $this->otherUser = User::factory()->make([
            'user_id' => 2,
            'role_id' => 2,
        ]);
    }

    protected function tearDown(): void
    {
        unset($this->careOrder);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            CareOrder::class,
            [],
            [],
            [],
            [],
            ['order_id' => 'int'],
            ['created_at', 'updated_at'],
            null,
            'care_orders',
            'order_id',
        );
    }

    public function testRelationships()
    {
        $this->testBelongToRelationship($this->careOrder->branch(), 'branch_id');
        $this->testBelongToRelationship($this->careOrder->user(), 'user_id');
        $this->testBelongToRelationship($this->careOrder->pet(), 'pet_id');
        $this->testBelongToRelationship($this->careOrder->coupon(), 'coupon_id');
        $this->assertInstanceOf(BelongsToMany::class, $this->careOrder->assignTask());
        $this->assertEquals('order_id', $this->careOrder->assignTask()->getForeignPivotKeyName());
        $this->assertEquals('user_id', $this->careOrder->assignTask()->getRelatedPivotKeyName());
        $this->assertEquals(['from_time', 'to_time'], $this->careOrder->assignTask()->getPivotColumns());

        $this->assertInstanceOf(HasOne::class, $this->careOrder->hotelService());
        $this->assertEquals('order_id', $this->careOrder->hotelService()->getForeignKeyName());
        $this->assertEquals('order_id', $this->careOrder->hotelService()->getLocalKeyName());

        $this->assertInstanceOf(BelongsToMany::class, $this->careOrder->careOrderDetail());
        $this->assertEquals('order_id', $this->careOrder->careOrderDetail()->getForeignPivotKeyName());
        $this->assertEquals('pet_service_id', $this->careOrder->careOrderDetail()->getRelatedPivotKeyName());
        $this->assertEquals(['pet_service_price'], $this->careOrder->careOrderDetail()->getPivotColumns());
    }

    public function testHasManyThroughPetService()
    {
        $this->assertInstanceOf(HasManyThrough::class, $this->careOrder->petServices());
        $this->assertEquals('order_id', $this->careOrder->petServices()->getFirstKeyName());
        $this->assertEquals('pet_service_id', $this->careOrder->petServices()->getSecondLocalKeyName());
        $this->assertEquals('order_id', $this->careOrder->petServices()->getLocalKeyName());
    }

    public function testGetOrderStatusNameAttribute()
    {
        $orderStatusNames = OrderStatusEnum::getTranslated();
        $this->assertEquals($orderStatusNames[$this->careOrder->order_status], $this->careOrder->order_status_name);
    }

    public function testIsCancelable()
    {
        $this->assertTrue($this->careOrder->isCancelable());

        $this->careOrder->order_status = OrderStatusEnum::COMPLETED;
        $this->assertFalse($this->careOrder->isCancelable());
    }

    public function testGetTotalPriceFormatAttribute()
    {
        $formattedPrice = formatNumber($this->careOrder->order_total_price, 'VND');
        $this->assertEquals($formattedPrice, $this->careOrder->total_price_format);
    }

    public function testCheckOwner()
    {
        $this->actingAs($this->user);
        $this->assertTrue($this->careOrder->checkOwner());
        $this->actingAs($this->otherUser);
        $this->assertFalse($this->careOrder->checkOwner());
    }

    public function testIsAssignable()
    {
        $this->assertTrue($this->careOrder->isAssignable());

        $this->careOrder->order_status = OrderStatusEnum::COMPLETED;
        $this->assertFalse($this->careOrder->isAssignable());
    }
}
