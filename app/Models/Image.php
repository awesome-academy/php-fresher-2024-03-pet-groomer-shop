<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'images';
    protected $fillable = ['image_path'];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
