<?php

namespace Tests\Unit\Models;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;
use Tests\Unit\ModelTestCase;

class CouponTest extends ModelTestCase
{
    protected $coupon;

    protected function setUp(): void
    {
        parent::setUp();
        $this->coupon = Coupon::factory()
            ->make([
                'coupon_code' => 'DISCOUNT2024',
                'coupon_price' => 10000,
                'expiry_date' => Carbon::now()->addDays(10),
                'is_active' => 1,
                'created_by' => 1,
            ]);
    }

    protected function tearDown(): void
    {
        unset($this->coupon);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationsAssertions(
            Coupon::class,
            [],
            [],
            [],
            [],
            [
                'coupon_id' => 'int',
                'deleted_at' => 'datetime',
            ],
            ['created_at', 'updated_at'],
            null,
            'coupons',
            'coupon_id',
        );
    }

    public function testRelationships()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->coupon->createdBy());
        $this->assertEquals('created_by', $this->coupon->createdBy()->getForeignKeyName());
        $this->assertEquals('user_id', $this->coupon->createdBy()->getOwnerKeyName());

        $this->assertInstanceOf(HasMany::class, $this->coupon->careOrders());
        $this->assertEquals('coupon_id', $this->coupon->careOrders()->getForeignKeyName());
        $this->assertEquals('coupon_id', $this->coupon->careOrders()->getLocalKeyName());
    }

    public function testGetIsActiveNameAttribute()
    {
        Config::set('constant.status', [
            0 => 'Inactive',
            1 => 'Active',
        ]);

        $this->assertEquals('Active', $this->coupon->is_active_name);
    }

    public function testGetFormatCouponPriceAttribute()
    {
        // Assuming the formatNumber function formats the number correctly
        $this->assertEquals('10.000 VND', $this->coupon->format_coupon_price);
    }
}
