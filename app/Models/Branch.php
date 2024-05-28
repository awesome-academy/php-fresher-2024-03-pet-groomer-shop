<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'branch_id';
    protected $table = 'branches';
    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id', 'branch_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function careOrders(): HasMany
    {
        return $this->hasMany(CareOrder::class, 'branch_id', 'branch_id');
    }
}
