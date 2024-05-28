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

    public function getPriceFormatAttribute()
    {
        return formatNumber($this->pet_service_price, 'VND');
    }

    public function getWeightFormatAttribute()
    {
        return formatNumber($this->pet_service_weight, 'KG');
    }
}
