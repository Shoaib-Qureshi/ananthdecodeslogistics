<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    protected $table = 'page_banners';

    protected $fillable = [
        'key',
        'eyebrow',
        'heading',
        'subheading',
        'image',
        'cta_label',
        'cta_link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function forKey(string $key): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }
}
