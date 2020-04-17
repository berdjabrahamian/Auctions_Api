<?php

namespace App\Listeners\MaxBid;

use App\Events\MaxBid\Outbid as MaxBidOutbidEvent;
use App\Mail\MaxBidOutbid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class OutbidEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'listeners';

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
     * @param  MaxBidOutbidEvent  $event
     *
     * @return void
     */
    public function handle(MaxBidOutbidEvent $event)
    {
        Mail::send(new MaxBidOutbid($event->maxBid));
    }
}
