<?php

namespace App\Observers;

use App\Events\CreatedAuctionEvent;
use App\Jobs\GenerateAuctionLog;
use App\Model\Auction\Auction;

class AuctionObserver
{

    public function retrieved(Auction $auction)
    {
    }

    public function creating(Auction $auction)
    {
    }


    public function created(Auction $auction)
    {
        //Init auction state
        event(new CreatedAuctionEvent($auction));

        //Generate Log - Auction Created
        GenerateAuctionLog::dispatch($auction, 'Auction Created');

        //Generate Log - Auction Started
        //This is delayed to run on the auction start date
        GenerateAuctionLog::dispatch($auction, 'Auction Started')->delay($auction->start_time);

        //Send Notification - Ending Soon
        //Schedule out to send out an auction ending soon email
        //The time is based on Auctoin::end_date - Store::final_notification_threshold


    }

    public function updating(Auction $auction)
    {
    }

    public function updated(Auction $auction)
    {
    }

    public function saving(Auction $auction)
    {
    }

    public function saved(Auction $auction)
    {
    }

    public function deleting(Auction $auction)
    {
    }

    public function deleted(Auction $auction)
    {
    }

    public function restoring(Auction $auction)
    {
    }

    public function restored(Auction $auction)
    {
    }
}
