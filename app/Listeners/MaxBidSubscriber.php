<?php

namespace App\Listeners;

use App\Events\MaxBidEvent;
use App\Mail\MaxBidOutbid as MaxBidOutbidEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MaxBidSubscriber implements ShouldQueue
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

    public function maxBidOutbid(MaxBidEvent $event)
    {
        Mail::send(new MaxBidOutbidEmail($event->maxBid));
    }

    public function maxBidCreated(MaxBidEvent $event)
    {
        Mail::send(new MaxBidCreatedEmail($event->maxBid));
    }
    
    public function subscribe($events)
    {
        $events->listen(
            MaxBidEvent::UPDATED,
            'App\Listeners\MaxBidSubscriber@maxBidOutbid'
        );

        $events->listen(
            MaxBidEvent::CREATED,
            'App\Listeners\MaxBidSubscriber@maxBidCreated'
        );


    }
}
