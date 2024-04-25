<?php

namespace App\Models;

use App\Scopes\ActiveUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $primaryKey = 'user_id';
    protected $table = 'users';

    /**
     * The attributes that are should not be mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['is_admin'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    protected $appends = [
        'full_name',
    ];

    // Override default attribute (password -> user_password in the method Authenticatable trait)
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    // Global scope
    protected static function booted()
    {
        static::addGlobalScope(new ActiveUserScope());
    }

    // local scope
    public function scopeAdmin($query)
    {
        return $query->where('is_admin', 1);
    }

    //Relations
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class, 'user_id', 'user_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function careOrders(): HasMany
    {
        return $this->hasMany(CareOrder::class, 'user_id', 'user_id');
    }

    public function assignTask(): BelongsToMany
    {
        return $this->belongsToMany(
            CareOrder::class,
            'assign_task',
            'user_id',
            'order_id'
        )->withPivot(['from_time', 'to_time'])->withTimestamps();
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class, 'created_by', 'user_id');
    }

    public function petServices(): HasMany
    {
        return $this->hasMany(PetService::class, 'created_by', 'user_id');
    }

    public function petServicesPrices(): HasMany
    {
        return $this->hasMany(PetServicePrice::class, 'created_by', 'user_id');
    }

    public function breeds(): HasMany
    {
        return $this->hasMany(Breed::class, 'created_by', 'user_id');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getFullNameAttribute(): string
    {
        return $this->user_first_name . ' ' . $this->user_last_name;
    }

    public function getGenderNameAttribute(): string
    {
        $checkGender = Config::get('constant.gender');

        return $checkGender[$this->gender];
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = Str::slug($value, '-');
    }

    public static function getUserByID($id)
    {
        return self::withoutGlobalScope(ActiveUserScope::class)->findOrFail($id);
    }
}
