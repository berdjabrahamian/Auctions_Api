<?php

namespace App\Observers;

use App\Events\Auction\AuctionCreated;
use App\Events\Auction\AuctionExtended as AuctionExtendedAlias;
use App\Events\CreatedAuctionEvent;
use App\Jobs\Auction\AuctionEnded;
use App\Jobs\Auction\AuctionEndedEmail;
use App\Jobs\Auction\AuctionEndingSoonEmail;
use App\Jobs\AuctionEndingSoonNotification;
use App\Jobs\GenerateAuctionLog;
use App\Listeners\NewAuctionState;
use App\Model\Auction\Auction;
use App\Model\Auction\State;
use App\Model\Store\Store;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class AuctionObserver
{

    public function retrieved(Auction $auction)
    {
//        AuctionEndingSoonEmail::dispatchNow($auction);

    }

    public function creating(Auction $auction)
    {
        $auction->current_price = $auction->initial_price;
    }

    public function created(Auction $auction)
    {
        //Init auction state
        AuctionCreated::dispatch($auction);

        //Generate Log - Auction Created
        GenerateAuctionLog::dispatch($auction, 'Auction Created');

        //Generate Log - Auction Started
        //This is delayed to run on the auction start date
        GenerateAuctionLog::dispatch($auction, 'Auction Started')->delay($auction->start_date);

        //Auction End
        AuctionEnded::dispatch($auction)->delay($auction->end_date);

        //Send Notification - Ending Soon
        AuctionEndingSoonEmail::dispatch($auction)->delay(Store::endingSoonThreshold($auction));

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
        if ($auction->isDirty('end_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Extended");
            AuctionEnded::dispatch($auction)->delay($auction->end_date);
        }

        if ($auction->wasChanged('start_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Delayed");
        }
    }
}
