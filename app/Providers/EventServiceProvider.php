<?php

namespace App\Providers;

use App\Models\OrderDetail;
use App\Models\Remission;
use App\Observers\OrderDetailObserver;
use App\Observers\RemissionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\StoredOrder' => [
            'App\Listeners\SendStoringNotification',
        ],
        'App\Events\UpdatedOrder' => [
            'App\Listeners\SendUpdatingNotification',
        ],
        'App\Events\StoredRemission' => [
            'App\Listeners\SendRemissionStorageNotification',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Remission::observe(RemissionObserver::class);
        OrderDetail::observe(OrderDetailObserver::class);
    }
}
