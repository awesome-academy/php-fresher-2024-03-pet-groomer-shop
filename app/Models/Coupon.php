<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    public static function getCoupon(string $code)
    {
        DB::beginTransaction();

        try {
            $coupon = self::where('coupon_code', trim($code))->lockForUpdate()->first();

            if ($coupon) {
                // Check if the coupon has expired
                $expiryDate = Carbon::parse($coupon->expiry_date);
                if ($expiryDate->isPast()) {
                    DB::rollBack();

                    return 'expired';
                }

                // Check if current_number has reached max_number
                if ($coupon->current_number >= $coupon->max_number) {
                    DB::rollBack();

                    return 'max_limit';
                }

                // Increase current_number by 1
                $coupon->current_number++;
                $coupon->save();

                DB::commit();

                return $coupon;
            }

            DB::rollBack();

            return 'not_found';
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
