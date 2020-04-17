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

    /**
     * Handle the bid "updated" event.
     *
     * @param  \App\Model\Auction\Bid  $bid
     *
     * @return void
     */
    public function updated(Bid $bid)
    {
        //
    }

    /**
     * Handle the bid "deleted" event.
     *
     * @param  \App\Model\Auction\Bid  $bid
     *
     * @return void
     */
    public function deleted(Bid $bid)
    {
        //
    }

    /**
     * Handle the bid "restored" event.
     *
     * @param  \App\Model\Auction\Bid  $bid
     *
     * @return void
     */
    public function restored(Bid $bid)
    {
        //
    }

    /**
     * Handle the bid "force deleted" event.
     *
     * @param  \App\Model\Auction\Bid  $bid
     *
     * @return void
     */
    public function forceDeleted(Bid $bid)
    {
        //
    }
}
