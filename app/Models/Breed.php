<?php

namespace App\Models;

use App\Enums\PetTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Breed extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'breed_id';
    protected $table = 'breeds';

    protected $guarded = [];

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class, 'breed_id', 'breed_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function getBreedTypeNameAttribute(): string
    {
        return PetTypeEnum::getTranslated()[$this->breed_type];
    }
}
