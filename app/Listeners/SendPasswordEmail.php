<?php

namespace App\Listeners;

use App\Events\PodcastProcessed;
use App\Mail\UserCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendPasswordEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Mail::to($event->user->email)
                ->send(new UserCreated($event->user));
    }
}
