<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetServicePrice extends Model
{
    use HasFactory;

    protected $primaryKey = 'pet_service_price_id';
    protected $table = 'pet_service_prices';
}
