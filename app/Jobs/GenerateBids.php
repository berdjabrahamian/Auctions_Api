<?php

namespace App\Jobs;

use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use App\Model\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateBids implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $maxBid;
    protected $customer;
    protected $auction;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, MaxBid $maxBid)
    {
        $this->customer = $customer;
        $this->maxBid   = $maxBid;
        $this->auction  = $this->_getAuction();
    }


    protected function _getAuction()
    {
        return Auction::find($this->maxBid->getAttribute('auction_id'));
    }


    /**
     * Lets show how this is going to run
     *
     * This is the first_bid in the auction
     *
     *
     * @return void
     */
    public function handle()
    {

    }
}
