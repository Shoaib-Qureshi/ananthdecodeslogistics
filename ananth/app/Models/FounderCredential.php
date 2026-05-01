<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FounderCredential extends Model
{
    protected $table = 'founder_credentials';

    protected $fillable = [
        'credential', 'sort_order',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
