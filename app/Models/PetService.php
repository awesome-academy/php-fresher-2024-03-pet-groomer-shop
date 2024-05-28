<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PetService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'pet_service_id';
    protected $table = 'pet_services';

    protected $guarded = [];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function petServicePrice(): HasMany
    {
        return $this->hasMany(PetServicePrice::class, 'pet_service_id', 'pet_service_id');
    }

    public function careOrderDetail(): BelongsToMany
    {
        return $this->belongsToMany(
            CareOrder::class,
            'care_order_detail',
            'pet_service_id',
            'order_id'
        )->with(['pet_service_price'])->withTimestamps();
    }
}
