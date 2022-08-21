<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The subject of the message.
     *
     * @var string
     */
    public $subject;

    private $user;
    private $oldEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $oldEmail)
    {
        $this->user = $user;
        $this->oldEmail = $oldEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $role = $this->user->roles()->first();
        $data = [
            'role' => ucfirst($role->name),
            'name' => $this->user->name,
            'email' => $this->user->email,
            'old_email' => $this->oldEmail,
            'url' => route('home')
        ];

        $this->subject = $data['name']. " (". $data['role'] . ") updated email!";

        return $this->markdown('emails.users.user-email-updated',$data);
    }
}
