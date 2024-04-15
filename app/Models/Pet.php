<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $primaryKey = 'pet_id';
    protected $table = 'pets';

    protected $fillable = [
        'pet_name',
        'pet_type',
        'pet_description',
        'pet_gender',
        'pet_weight',
        'pet_birthdate',
    ];
}
