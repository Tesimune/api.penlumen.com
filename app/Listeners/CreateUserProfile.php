<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class CreateUserProfile
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $event->user->profile()->create([]);
    }
}
