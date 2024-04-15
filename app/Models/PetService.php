<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetService extends Model
{
    use HasFactory;

    protected $primaryKey = 'pet_service_id';
    protected $table = 'pet_services';
}
