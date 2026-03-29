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
        'stat_label'
    ];
}
