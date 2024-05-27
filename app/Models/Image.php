<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

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

    public function upload($request, $imageField, $imageable)
    {
        try {
            $request->validate([
                $imageField => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imageFile = $request->file($imageField);

            $currentImage = $imageable->image ?? null;

            // If the user has a current image, delete it
            if ($currentImage) {
                Storage::delete('images/' . $currentImage->image_path);
                $currentImage->delete();
            }

            // Store the file locally
            $path = $imageFile->store('images');

            $this->image_path = $path;

            $imageable->image()->save($this);

            flashMessage('success', trans('image.create_success'));
        } catch (Exception $e) {
            flashMessage('error', $e->getMessage());
        }
    }
}
