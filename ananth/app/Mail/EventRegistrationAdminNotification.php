<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventRegistrationAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public EventRegistration $registration;

    public function __construct(EventRegistration $registration)
    {
        $this->registration = $registration->loadMissing('event');
    }

    public function build()
    {
        return $this->subject('New LogiSphere registration - ' . $this->registration->name)
            ->replyTo($this->registration->email, $this->registration->name)
            ->view('emails.events.registration-admin');
    }
}
