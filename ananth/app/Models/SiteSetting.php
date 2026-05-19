<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'footer_tagline',
        'footer_company_name',
        'footer_copyright',
        'cin',
        'social_linkedin',
        'social_twitter',
        'social_instagram',
        'footer_logo',
        'gallery_page_visible',
    ];

    protected $casts = [
        'gallery_page_visible' => 'boolean',
    ];

    public static function instance(): self
    {
        return static::firstOrNew(['id' => 1]);
    }

    public static function galleryPageVisible(): bool
    {
        return (bool) (static::first()?->gallery_page_visible ?? true);
    }
}
