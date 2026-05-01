<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertDeskPillar extends Model
{
    protected $table = 'expert_desk_pillars';

    protected $fillable = [
        'title', 'body', 'sort_order',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
