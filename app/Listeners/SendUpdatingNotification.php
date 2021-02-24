<?php

namespace App\Listeners;

use App\Events\UpdatedOrder;
use App\Models\User;
use App\Notifications\UpdatedOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendUpdatingNotification implements ShouldQueue
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
     * @param  UpdatedOrder  $event
     * @return void
     */
    public function handle(UpdatedOrder $event)
    {
        $isAdmin = Auth::user()->isAdmin();

        if (! $isAdmin) {

           $emails = User::getEmailsUsersByRol([1,2]);

            Notification::route('mail', $emails)
                                ->notify(new UpdatedOrderNotification($event->order));
        }
    }
}
