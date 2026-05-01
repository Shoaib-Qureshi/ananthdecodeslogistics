<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCard extends Model
{
    protected $table = 'service_cards';

    protected $fillable = [
        'title', 'description', 'icon', 'status',
        'link_url', 'sort_order', 'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function scopeVisible($query)
    {
        return $query->where('visible', true)->orderBy('sort_order');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
