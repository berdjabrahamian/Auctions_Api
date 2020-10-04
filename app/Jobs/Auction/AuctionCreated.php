<?php

namespace App\Jobs\Auction;

use App\Jobs\GenerateAuctionLog;
use App\Model\Auction\Auction;
use App\Model\Auction\State;
use App\Model\Store\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AuctionCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries         = 1;
    public $maxExceptions = 1;
    public $auction;
    public $state;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction->makeVisible('id');
        $this->state = new State();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->_newAuctionState();

        //Generate Log - Auction Created
        GenerateAuctionLog::dispatch($this->auction, 'Auction Created');

        //Generate Log - Auction Started
        //This is delayed to run on the auction start date
        GenerateAuctionLog::dispatch($this->auction, 'Auction Started')->delay($this->auction->start_date);

        //Auction End
        AuctionEnded::dispatch($this->auction)->delay($this->auction->end_date);

        //Send Notification - Ending Soon
        AuctionEndingSoonEmail::dispatch($this->auction)->delay(Store::endingSoonThreshold($this->auction));

    }

    protected function _newAuctionState()
    {

        $this->state->auction_id    = $this->auction->id;
        $this->state->current_price = $this->auction->initial_price;
        $this->state->save();

        return $this->state;
    }
}
