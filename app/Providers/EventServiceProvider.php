<?php

namespace App\Providers;

use App\Events\CreatedAuctionEvent;
use App\Listeners\Auction\CreateAuctionState;
use App\Listeners\CreatedAuction;
use App\Listeners\MaxBidSubscriber;
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
        Registered::class          => [
            SendEmailVerificationNotification::class,
        ],
        CreatedAuctionEvent::class => [
            CreateAuctionState::class,
        ],
    ];

    protected $subscribe = [
        MaxBidSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
