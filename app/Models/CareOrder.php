<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $table = 'care_orders';
}
