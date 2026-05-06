<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventRegistrationNotInterested extends Mailable
{
    use Queueable, SerializesModels;

    public EventRegistration $registration;

    public function __construct(EventRegistration $registration)
    {
        $this->registration = $registration->loadMissing('event');
    }

    public function build()
    {
        return $this->subject('Update on your LogiSphere registration interest')
            ->view('emails.events.registration-not-interested');
    }
}
