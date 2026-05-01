<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    protected $table = 'home_page_settings';

    protected $fillable = [
        'hero_eyebrow', 'hero_heading', 'hero_subheading', 'hero_image',
        'hero_cta_primary_label', 'hero_cta_primary_link',
        'hero_cta_secondary_label', 'hero_cta_secondary_link',
        'stat1_number', 'stat1_label', 'stat2_number', 'stat2_label',
        'stat3_number', 'stat3_label', 'stat4_number', 'stat4_label',
        'founder_eyebrow', 'founder_heading', 'founder_title_badge',
        'founder_bio', 'founder_photo', 'founder_cta_label', 'founder_cta_link',
        'expertdesk_eyebrow', 'expertdesk_heading', 'expertdesk_body',
        'expertdesk_cta1_label', 'expertdesk_cta1_link',
        'expertdesk_cta2_label', 'expertdesk_cta2_link',
        'boardinsights_eyebrow', 'boardinsights_heading', 'boardinsights_body',
        'boardinsights_cta_label', 'boardinsights_cta_link',
        'services_eyebrow', 'services_heading', 'services_intro',
        'blog_eyebrow', 'blog_heading', 'blog_subheading',
        'blog_cta_label', 'blog_cta_link',
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
