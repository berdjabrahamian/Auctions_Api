<?php

namespace App\Listeners;

use App\Events\UpdatingMaxBidEvent;
use App\Exceptions\MaxBidException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdatingMaxBid
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
     * @return void
     */
    public function handle(UpdatingMaxBidEvent $event)
    {
        $originalBid = $event->maxBid->getOriginal('amount');
        $newBid      = $event->maxBid->getAttribute('amount');

        if ($newBid < $originalBid) {
            throw new MaxBidException("New Max Bid, cant bet less than your current Max Bid of {$originalBid}", 403);
        }

        return;

    }
}
