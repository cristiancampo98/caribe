<?php

namespace App\Listeners;

use App\Events\StoredOrder;
use App\Models\User;
use App\Notifications\StoredOrder as StoredOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendStoringNotification implements ShouldQueue
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
     * @param  StoredOrder  $event
     * @return void
     */
    public function handle(StoredOrder $event)
    {
        $isAdmin = Auth::user()->isAdmin();

        if (! $isAdmin) {

           $emails = User::getEmailsUsersByRol([1,2]);

            Notification::route('mail', $emails)
                                ->notify(new StoredOrderNotification($event->order));
        }
        
    }
}
