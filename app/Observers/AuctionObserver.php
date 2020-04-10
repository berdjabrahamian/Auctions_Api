<?php

namespace App\Observers;

use App\Events\CreatedAuctionEvent;
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

        //Send Notification - Ending Soon
        //Schedule out to send out an auction ending soon email
        //The time is based on Auction::end_date - Store::final_notification_threshold
        $endDate             = Carbon::make($auction->end_date);
        $endSoonNotification = Store::find($auction->store_id)->ending_soon_notification;
        $dispatchTime        = $endDate->subMinutes($endSoonNotification);
        GenerateAuctionLog::dispatch($auction, 'Auction Ended')->delay($dispatchTime);

    }

    public function updating(Auction $auction)
    {
    }

    public function updated(Auction $auction)
    {

        if ($auction->getChanges('end_date')) {
            GenerateAuctionLog::dispatch($auction, "Auction Extended");
        }

        if ($auction->getChanges('start_date')) {
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
