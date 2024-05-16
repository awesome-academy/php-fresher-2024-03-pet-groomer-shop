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

    public static function checkValidName($request): bool
    {
        return self::where('breed_name', $request->breed_name)
            ->where('breed_type', $request->breed_type)->exists();
    }

    public static function checkValidNameUpdate($request, $id): bool
    {
        $breed = self::find($id);
        if ($breed->breed_name === $request->breed_name && $breed->breed_type === $request->breed_type) {
            return false;
        }

        return self::where('breed_name', $request->breed_name)
            ->where('breed_type', $request->breed_type)->exists();
    }

    public static function checkValidPetType($breedID, $petType): bool
    {
        $breed = self::find($breedID);

        return (int) $breed->breed_type === (int) $petType;
    }
}
