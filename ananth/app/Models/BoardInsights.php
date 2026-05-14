<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardInsights extends Model
{
    use HasFactory;
    protected $table = 'board_insights';

    protected $casts = [
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
    ];
}
