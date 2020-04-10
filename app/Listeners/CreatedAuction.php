<?php

namespace App\Listeners;

use App\Events\CreatedAuctionEvent;
use App\Model\Auction\State;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreatedAuction implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle(CreatedAuctionEvent $event)
    {
        $auction = $event->auction;

        $state = new State();

        $state->auction_id    = $auction->id;
        $state->current_price = $auction->initial_price;
        $state->save();

        return $this;
    }
}
