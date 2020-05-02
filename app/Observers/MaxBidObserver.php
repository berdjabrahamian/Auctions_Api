<?php

namespace App\Observers;

use App\Events\MaxBid\Created;
use App\Events\MaxBid\Outbid;
use App\Events\MaxBid\Updated;
use App\Jobs\GenerateAuctionLog;
use App\Jobs\MaxBid\MaxBidCreatedEmail;
use App\Jobs\MaxBid\MaxBidOutbidEmail;
use App\Jobs\MaxBid\MaxBidUpdatedEmail;
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
        //Create a log in the LOGS table that the max bid was created
        GenerateAuctionLog::dispatch($maxBid->auction_id, 'Max Bid Created',
            ['customer_id' => $maxBid->customer_id, 'amount' => $maxBid->amount]);

        //This will dispatch a job that will Send the MaxBid Created Email
        MaxBidCreatedEmail::dispatchAfterResponse($maxBid);
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
        if ($maxBid->wasChanged('amount')) {
            GenerateAuctionLog::dispatch($maxBid->auction_id, 'Max Bid Updated',
                ['customer_id' => $maxBid->customer_id, 'amount' => $maxBid->amount]);

            MaxBidUpdatedEmail::dispatchAfterResponse($maxBid);
        }

        //This will dispatch a listener that will Send the MaxBid Outbid Email
        if ($maxBid->wasChanged('outbid')) {
            if ($maxBid->outbid) {
                MaxBidOutbidEmail::dispatchAfterResponse($maxBid);
            }
        }
    }
}
