<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CareOrderDetail extends Pivot
{
    use HasFactory;

    protected $table = 'care_order_detail';
    protected $guarded = [];
}
