<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Notifications\CommentAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationListener
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
    public function handle(SendNotification $event)
    {
        $event->user->notify(new CommentAdded());
    }
}
