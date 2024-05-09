<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CareOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $table = 'care_orders';

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'coupon_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function assignTask(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'assign_task',
            'order_id',
            'user_id'
        )->withPivot(['from_time', 'to_time']);
    }

    public function hotelServices(): HasOne
    {
        return $this->hasOne(HotelService::class, 'order_id', 'order_id');
    }

    public function careOrderDetail(): BelongsToMany
    {
        return $this->belongsToMany(
            PetService::class,
            'care_order_detail',
            'order_id',
            'pet_service_id'
        )->withPivot(['pet_service_price'])->withTimestamps();
    }

    public function getOrderStatusNameAttribute()
    {
        $orderStatusNames = OrderStatusEnum::getTranslated();

        return $orderStatusNames[$this->order_status];
    }
}
