<?php

namespace App\Listeners;

use App\Events\MaxBidOutbidEvent;
use App\Mail\MaxBidOutbid as MaxBidOutbidEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MaxBidOutbid
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
     * @param  object  $event
     *
     * @return void
     */
    public function handle(MaxBidOutbidEvent $event)
    {
        Mail::send(new MaxBidOutbidEmail($event->maxBid));

        return $this;
    }
}
