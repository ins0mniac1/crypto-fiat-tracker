<?php

namespace App\Mail;

use App\Models\Users\NotifyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserMail extends Mailable
{
    use Queueable, SerializesModels;

    private NotifyUser $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NotifyUser $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->markdown('Email.notifyUsersMail')->with('user', $this->user);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
