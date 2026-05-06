<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id', 'inquiry_type', 'name', 'email', 'phone', 'company',
        'designation', 'message', 'consent', 'status',
    ];

    protected $casts = ['consent' => 'boolean'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
