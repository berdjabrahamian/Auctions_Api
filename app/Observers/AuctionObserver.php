<?php

namespace App\Observers;

use App\Events\CreatedAuctionEvent;
use App\Jobs\Auction\AuctionEndingSoonEmail;
use App\Jobs\AuctionEndingSoonNotification;
use App\Jobs\GenerateAuctionLog;
use App\Model\Auction\Auction;
use App\Model\Auction\State;
use App\Model\Store\Store;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class AuctionObserver
{
    public function creating(Auction $auction)
    {
        $auction->current_price = $auction->initial_price;
    }


    public function created(Auction $auction)
    {
        //Init auction state
        event(new CreatedAuctionEvent($auction));

        //Generate Log - Auction Created
        GenerateAuctionLog::dispatch($auction, 'Auction Created');

        //Generate Log - Auction Started
        //This is delayed to run on the auction start date
        GenerateAuctionLog::dispatch($auction, 'Auction Started')->delay($auction->start_date);

        //TODO: This needs to run in a event to check that the end date is NOW
        //Generate Log - Auction Ended
        //This is run when on the auction end date
        GenerateAuctionLog::dispatch($auction, 'Auction Ended')->delay($auction->end_date);


        //Send Notification - Ending Soon
        //Schedule out to send out an auction ending soon email
        //The time is based on Auction::end_date - Store::final_notification_threshold
        AuctionEndingSoonEmail::dispatch($auction)->delay($auction->getEndingSoonDate());

    }

    public function updating(Auction $auction)
    {
        if ($auction->isDirty('current_price')) {
            if ($auction->isLastMinuteBid()) {
                $auction->end_date = $auction->end_date->addMinutes($auction->store->final_extension_duration);
            }
        }

    }

    public function updated(Auction $auction)
    {
        if ($auction->wasChanged('end_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Extended");
        }

        if ($auction->wasChanged('start_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Delayed");
        }
    }
}
