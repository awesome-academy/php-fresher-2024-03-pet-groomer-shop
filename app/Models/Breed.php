<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breeds extends Model
{
    use HasFactory;

    protected $primaryKey = 'breed_id';
    protected $table = 'breeds';
}
