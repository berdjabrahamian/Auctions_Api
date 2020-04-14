<?php

namespace App\Observers;

use App\Events\CreatedAuctionEvent;
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
    public function retrieved(Auction $auction)
    {
    }

    public function creating(Auction $auction)
    {
        $auction->current_price = $auction->initial_price;
        return $this;
    }


    public function created(Auction $auction)
    {
        //Init auction state
        event(new CreatedAuctionEvent($auction));

        //Generate Log - Auction Created
        GenerateAuctionLog::dispatch($auction, 'Auction Created');

        //Generate Log - Auction Started
        //This is delayed to run on the auction start date
        $startDate = Carbon::make($auction->start_date);
        GenerateAuctionLog::dispatch($auction, 'Auction Started')->delay($startDate);

        //Generate Log - Auction Ended
        //This is run when on the auction end date
        $endDate = Carbon::make($auction->end_date);
        GenerateAuctionLog::dispatch($auction, 'Auction Ended')->delay($endDate);


        //Send Notification - Ending Soon
        //Schedule out to send out an auction ending soon email
        //The time is based on Auction::end_date - Store::final_notification_threshold
        AuctionEndingSoonNotification::dispatch($auction)->delay($auction->ending_ss);

    }

    public function updating(Auction $auction)
    {


    }

    public function updated(Auction $auction)
    {
        if ($auction->wasChanged('end_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Extended");
        }

        if ($auction->wasChanged('start_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Delayed");
        }

//        if ($auction->getChanges()) {
//            $updates = Arr::except($auction->getChanges(), 'updated_at');
//            foreach ($updates as $key => $value) {
//                GenerateAuctionLog::dispatch($auction, "Auction {$key} Updated");
//            }
//        }
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
