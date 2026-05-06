<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = [
        'title', 'category', 'caption', 'image', 'sort_order', 'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function imageUrl(): string
    {
        if (!$this->image) {
            return asset('img/blank-picture.webp');
        }

        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, '/')) {
            return $this->image;
        }

        return Storage::url($this->image);
    }
}
