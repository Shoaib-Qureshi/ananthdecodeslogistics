<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAgendaItem extends Model
{
    protected $fillable = ['event_id', 'start_time', 'end_time', 'duration', 'session_type', 'title', 'description', 'sort_order', 'visible'];

    protected $casts = ['visible' => 'boolean'];
}
