<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'coupon_id';
    protected $table = 'coupons';
    protected $guarded = [];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function careOrders(): HasMany
    {
        return $this->hasMany(CareOrder::class, 'coupon_id', 'coupon_id');
    }

    public function getIsActiveNameAttribute(): string
    {
        return StatusEnum::getTranslated()[$this->is_active];
    }

    public function getFormatCouponPriceAttribute(): string
    {
        return formatNumber($this->coupon_price, 'VND');
    }
}
