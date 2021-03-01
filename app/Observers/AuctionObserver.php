<?php

namespace App\Observers;

use App\Events\Auction\AuctionCreated;
use App\Events\Auction\AuctionExtended;
use App\Events\Auction\AuctionExtended as AuctionExtendedAlias;
use App\Jobs\Auction\AuctionCreated as AuctionCreateHandle;
use App\Jobs\Auction\AuctionEnded;
use App\Jobs\Auction\AuctionEndedEmail;
use App\Jobs\Auction\AuctionEndingSoonEmail;
use App\Jobs\Auction\AuctionExtendedEmail;
use App\Jobs\AuctionEndingSoonNotification;
use App\Jobs\GenerateAuctionLog;
use App\Model\Auction\Auction;

use App\Model\Store\Store;


class AuctionObserver
{

    public function retrieved(Auction $auction)
    {
    }

    public function creating(Auction $auction)
    {
        $auction->current_price = $auction->initial_price;
    }

    public function created(Auction $auction)
    {
        //Init auction state
        AuctionCreateHandle::dispatch($auction);
        //TODO: This needs to be based on the store it actually belongs to
        AuctionCreated::dispatch($auction);
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
            AuctionExtendedEmail::dispatchAfterResponse($auction);
        }

        if ($auction->wasChanged('start_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Delayed");
        }
    }
}
