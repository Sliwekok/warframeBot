<?php

namespace App\Listener;

use App\Events\sendNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Notifications implements ShouldQueue
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
     * @param  sendNotification  $event
     * @return void
     */
    public function handle(sendNotification $event)
    {
        $user = DB::table('users')->where('name',  $event->user->name)->first();
        $user->notify(new PriceNotifications($user->name, $event->message));
        
    }
}
