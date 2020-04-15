<?php

namespace App\Listeners\MaxBid;

use App\Events\MaxBid\Updated as MaxBidUpdatedEvent;
use App\Mail\MaxBidUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UpdatedEmail
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
     * @param  MaxBidUpdatedEvent  $event
     *
     * @return void
     */
    public function handle(MaxBidUpdatedEvent $event)
    {
        Mail::send(new MaxBidUpdated($event->maxBid));
    }
}
