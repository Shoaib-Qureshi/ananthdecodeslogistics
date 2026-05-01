<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPageSetting extends Model
{
    protected $table = 'about_page_settings';

    protected $fillable = [
        'hero_eyebrow', 'hero_heading', 'hero_subheading', 'hero_image',
        'intro_eyebrow', 'intro_heading', 'intro_body',
        'vision_title', 'vision_body',
        'mission_title', 'mission_body',
        'values_title', 'values_body',
        'services_eyebrow', 'services_heading', 'services_intro',
        'transparency_note_title', 'transparency_note_body', 'transparency_note_disclaimer',
        'cta_heading', 'cta_body', 'cta1_label', 'cta1_link', 'cta2_label', 'cta2_link',
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url',
        'og_image', 'robots_index', 'robots_follow', 'schema_json_ld',
    ];

    protected $casts = [
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
    ];

    public static function instance(): self
    {
        return static::firstOrNew(['id' => 1]);
    }
}
