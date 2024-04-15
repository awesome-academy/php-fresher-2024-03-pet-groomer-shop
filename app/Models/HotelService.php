<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelService extends Model
{
    use HasFactory;

    protected $primaryKey = 'hotel_service_id';
    protected $table = 'hotel_services';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function careOrder(): BelongsTo
    {
        return $this->belongsTo(CareOrder::class, 'order_id', 'order_id');
    }
}
