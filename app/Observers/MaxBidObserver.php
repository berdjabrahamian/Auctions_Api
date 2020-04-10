<?php

namespace App\Observers;

use App\Jobs\GenerateAuctionLog;
use App\Model\Auction\MaxBid;

class MaxBidObserver
{
    /**
     * Handle the max bid "created" event.
     *
     * @param  \App\Model\Auction\MaxBid  $maxBid
     *
     * @return void
     */
    public function created(MaxBid $maxBid)
    {
        GenerateAuctionLog::dispatch($maxBid->auction_id, 'Max Bid Created',
            ['customer_id' => $maxBid->customer_id, 'amount' => $maxBid->amount]);
    }

    /**
     * Handle the max bid "updated" event.
     *
     * @param  \App\Model\Auction\MaxBid  $maxBid
     *
     * @return void
     */
    public function updated(MaxBid $maxBid)
    {
        if ($maxBid->getChanges('amount')) {
            GenerateAuctionLog::dispatch($maxBid->auction_id, 'Max Bid Updated',
                ['customer_id' => $maxBid->customer_id, 'amount' => $maxBid->amount]);
        }
    }

    /**
     * Handle the max bid "deleted" event.
     *
     * @param  \App\Model\Auction\MaxBid  $maxBid
     *
     * @return void
     */
    public function deleted(MaxBid $maxBid)
    {
        //
    }

    /**
     * Handle the max bid "restored" event.
     *
     * @param  \App\Model\Auction\MaxBid  $maxBid
     *
     * @return void
     */
    public function restored(MaxBid $maxBid)
    {
        //
    }

    /**
     * Handle the max bid "force deleted" event.
     *
     * @param  \App\Model\Auction\MaxBid  $maxBid
     *
     * @return void
     */
    public function forceDeleted(MaxBid $maxBid)
    {
        //
    }
}
