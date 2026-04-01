<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'heading',
        'subheading',
        'content',
        'image',
        'button_text',
        'button_link',
        'stat_number',
        'stat_label',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image',
        'robots_index',
        'robots_follow',
        'schema_json_ld',
    ];
}
