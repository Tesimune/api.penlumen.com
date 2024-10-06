<?php

namespace App\Listeners\V1;

use App\Mail\V1\EmailVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Support\Facades\Mail;

class SendNewUserNotification implements ShouldQueueAfterCommit
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
    public function handle(\App\Events\V1\UserRegistered $event): void
    {
        Mail::to($event->user->email)
            ->send(new EmailVerificationMail($event->user));
    }
}
