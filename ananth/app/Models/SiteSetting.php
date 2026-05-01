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
    ];

    public static function instance(): self
    {
        return static::firstOrNew(['id' => 1]);
    }
}
