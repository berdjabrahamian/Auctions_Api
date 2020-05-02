<?php

namespace App\Observers;

use App\Jobs\GenerateAuctionLog;
use App\Model\Auction\Bid;

class BidObserver
{
    /**
     * Handle the bid "created" event.
     *
     * @param  \App\Model\Auction\Bid  $bid
     *
     * @return void
     */
    public function created(Bid $bid)
    {
        GenerateAuctionLog::dispatch($bid->auction, 'Bid Created',
            ['customer_id' => $bid->customer_id, 'amount' => $bid->amount]);
    }
}
