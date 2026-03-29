<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContributorPost;

class NewPostAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public ContributorPost $post;

    public function __construct(ContributorPost $post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('New Contributor Post Pending Review — ' . $this->post->title)
                    ->view('emails.contributor.new-post');
    }
}
