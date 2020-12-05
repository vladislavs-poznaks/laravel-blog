<?php

namespace App\Listeners;

use App\Mail\GeneratedPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendGeneratedPasswordNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Registered $event)
    {
        Mail::to($event->user)
            ->send(new GeneratedPassword($event->password));
    }
}
