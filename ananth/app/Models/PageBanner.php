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

    public static function manageableKeys(): array
    {
        return [
            'blog' => 'Blog banner',
            'expert_desk' => 'The Expert Desk banner',
            'board_insights' => 'Board Insights banner',
            'book_reviews' => 'Book Reviews banner',
            'write_for_us' => 'Write for Us banner',
            'contributor_apply' => 'Expert Desk Apply banner',
            'free_signup' => 'Free Signup banner',
            'gallery' => 'Gallery banner',
            'contact' => 'Contact banner',
            'privacy_policy' => 'Privacy Policy banner',
            'terms_conditions' => 'Terms & Conditions banner',
            'disclaimer' => 'Disclaimer banner',
        ];
    }
}
