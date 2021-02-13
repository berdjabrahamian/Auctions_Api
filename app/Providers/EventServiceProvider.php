<?php

namespace App\Providers;

use App\Events\Auction\AuctionCreated;
use App\Listeners\Auction\NewAuctionState;
use App\Listeners\LogCustomerNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class     => [
            SendEmailVerificationNotification::class,
        ],
//        AuctionCreated::class => [
//            NewAuctionState::class,
//        ],

        MessageSending::class => [
            LogCustomerNotification::class,
        ],
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
