<?php

namespace App\Listeners;

use App\Events\StoredRemission;
use App\Notifications\StoredRemissionNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendRemissionStorageNotification implements ShouldQueue
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
     * @param  StoredRemission  $event
     * @return void
     */
    public function handle(StoredRemission $event)
    {
        $email = $event->remission->orderDetail->order->client->email;
        Notification::route('mail', $email)
                                ->notify(new StoredRemissionNotification($event->remission));
    }
}
