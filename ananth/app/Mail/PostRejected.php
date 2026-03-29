<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContributorPost;

class PostRejected extends Mailable
{
    use Queueable, SerializesModels;

    public ContributorPost $post;

    public function __construct(ContributorPost $post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('Your post submission — Ananth Decodes Logistics')
                    ->view('emails.contributor.post-rejected');
    }
}
