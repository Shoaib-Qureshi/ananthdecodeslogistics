<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFaq extends Model
{
    protected $fillable = ['event_id', 'question', 'answer', 'sort_order', 'visible'];

    protected $casts = ['visible' => 'boolean'];
}
