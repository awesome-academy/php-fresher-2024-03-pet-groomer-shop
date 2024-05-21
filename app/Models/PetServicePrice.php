<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PetServicePrice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'pet_service_price_id';
    protected $table = 'pet_service_prices';
    protected $guarded = [];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function petService(): BelongsTo
    {
        return $this->belongsTo(PetService::class, 'pet_service_id', 'pet_service_id');
    }

    public static function checkExistWeight($petServiceID, $weight): bool
    {
        return self::where('pet_service_id', $petServiceID)->where('pet_service_weight', $weight)->exists();
    }

    public function getPriceFormatAttribute()
    {
        return formatNumber($this->pet_service_price, 'VND');
    }

    public function getWeightFormatAttribute()
    {
        return formatNumber($this->pet_service_weight, 'KG');
    }

    public static function getPriceByWeight($petServiceID, $weight)
    {
        $prices = self::where('pet_service_id', $petServiceID)->orderBy('pet_service_weight', 'asc')->get();
        if ($prices->isEmpty()) {
            return 0;
        }

        if ($prices->count() === 1) {
            return (float) $prices->first()->pet_service_price;
        }

        foreach ($prices as $price) {
            if (ceil($weight) <= (int) $price->pet_service_weight) {
                return (float) $price->pet_service_price;
            }
        }

        return (float) $prices->last()->pet_service_price;
    }
}
