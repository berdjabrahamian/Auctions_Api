<?php

namespace App\Jobs;

use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use App\Model\Auction\State;
use App\Model\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateBids implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    protected $maxBid;
    protected $customer;
    protected $auction;
    protected $state;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, MaxBid $maxBid)
    {
        $this->customer = $customer;
        $this->maxBid   = $maxBid;
        $this->auction  = $this->setAuction(Auction::find($this->maxBid->auction_id)->first());
        $this->state    = $this->setState(State::find($this->auction->id));
    }


    /**
     * This will handle the following:
     * Bid Generation
     * Updating Auction State
     * Updating Outbids
     * Schedule Email
     *
     *
     * HOW DO BIDS WORK
     * when a bid is placed if its higher than the current auction current_price
     * then we increase the auction current_price by the min_bid_cents
     * we mark the auction state the max_bid id so that its marked as leader
     *
     *
     *
     * CASE 1 - First Auction Bid
     * Update AUCTION:current_price
     * Update STATE:leading_id
     * Update STATE:current_price
     *
     *
     * CASE 2 - The bidder is jut updating there max bid
     *
     *
     *
     * CASE 3 - Same bid as current winner
     * CASE 4 - Highest Bidder of all bidders
     *
     *
     * @see Auction::newCurrentPrice()
     * @see Auction::placeBid()
     *
     */
    public function handle()
    {
        $stateLeadingBidId = $this->state->leading_id;

        $newAuctionCurrentPrice = $this->auction->newCurrentPrice($this->maxBid, $this->state);

        /**
         * CASE 1
         * This is a the first max bid for the auction
         * There should not be any leading_id in the Auction State
         *
         */
        if (!$this->state->leading_id) {
            $this->auction->placeBid($newAuctionCurrentPrice, $this->customer);
            $this->state->update([
                'leading_id'    => $this->maxBid->id,
                'current_price' => $newAuctionCurrentPrice,
            ]);
        }

        /**
         * CASE 2
         * The auction already has a bid and im just updating my max bid
         */




        dd('asdadasdas');

        return $this;
    }

    /**
     * @param  mixed  $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @param  mixed  $auction
     */
    public function setAuction($auction): void
    {
        $this->auction = $auction;
    }
}
