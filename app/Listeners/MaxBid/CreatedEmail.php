<?php

namespace App\Listeners\MaxBid;

use App\Events\MaxBid\Created as MaxBidCreatedEvent;
use App\Mail\MaxBidCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CreatedEmail implements ShouldQueue
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
     * @param  MaxBidCreatedEvent  $event
     *
     * @return void
     */
    public function handle(MaxBidCreatedEvent $event)
    {
        Mail::send(new MaxBidCreated($event->maxBid));
    }
}
