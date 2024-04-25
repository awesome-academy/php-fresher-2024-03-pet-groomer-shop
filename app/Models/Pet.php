<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'pet_id';
    protected $table = 'pets';

    protected $casts = [
        'pet_birthdate' => 'date',
    ];

    protected $fillable = [
        'pet_name',
        'pet_type',
        'pet_description',
        'pet_gender',
        'pet_weight',
        'pet_birthdate',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class, 'breed_id', 'breed_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function careOrders(): HasMany
    {
        return $this->hasMany(CareOrder::class, 'pet_id', 'pet_id');
    }
}
