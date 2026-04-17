<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminCreatedContributor extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $resetUrl;

    public function __construct(User $user, string $resetUrl)
    {
        $this->user     = $user;
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this->subject('Your Expert Desk account is ready — set your password to get started')
                    ->view('emails.contributor.admin-created');
    }
}
