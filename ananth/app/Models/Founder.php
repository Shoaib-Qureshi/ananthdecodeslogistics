<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Founder extends Model
{
    protected $table = 'founders';

    protected $fillable = [
        'eyebrow', 'name', 'title', 'bio',
        'photo', 'signature_image', 'sort_order', 'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function scopeVisible($query)
    {
        return $query->where('visible', true)->orderBy('sort_order');
    }
}
