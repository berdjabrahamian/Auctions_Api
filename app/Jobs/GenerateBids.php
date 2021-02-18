<?php

namespace App\Jobs;

use App\Model\Auction\Auction;
use App\Model\Auction\Bid;
use App\Model\Auction\MaxBid;
use App\Model\Auction\State;
use App\Model\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class GenerateBids
 *
 * @package App\Jobs
 * @deprecated Running this as a model and not background task as we need to control if errors happen in realtime
 */
class GenerateBids implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public    $tries = 3;
    protected $maxBid;
    protected $customer;
    protected $auction;
    protected $state;
    public    $newAuctionCurrentPrice;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, MaxBid $maxBid)
    {
        $this->customer = $customer;
        $this->maxBid   = $maxBid;
        $this->auction  = $maxBid->auction;
        $this->state    = State::where('auction_id', $this->auction->id)->first();
    }


    /**
     * This will handle the following:
     * Bid Generation
     * Updating Auction State
     * Updating Outbids
     * Schedule Email
     *
     * HOW DO BIDS WORK
     * when a bid is placed if its higher than the current auction current_price
     * then we increase the auction current_price by the min_bid_cents
     * we mark the auction state the max_bid id so that its marked as leader
     *
     * CASE 1 - First Auction Bid
     * CASE 2 - Customer is updating there max bid
     * CASE 3 - There is an existing bid on the auction and this is less than
     * CASE 4 - Same bid as current winner
     * CASE 5 - Highest Bidder of all bidders
     *
     * @see Auction::newCurrentPrice()
     * @see Auction::placeBid()
     *
     */
    public function handle()
    {
        $stateLeadingBidId            = $this->state->leading_id;
        $this->newAuctionCurrentPrice = $this->auction->newCurrentPrice($this->maxBid, $this->state);

        /**
         *
         * CASE 1
         * This is a the first max bid for the auction
         * There should not be any leading_id in the Auction State
         *
         * Update AUCTION:current_price
         * Update STATE:leading_id
         * Update STATE:current_price
         */
        if (!$this->state->leading_id) {
            Bid::placeBid($this->newAuctionCurrentPrice, $this->customer, $this->auction);

            $this->state->update([
                'leading_id'    => $this->maxBid->id,
                'current_price' => $this->newAuctionCurrentPrice,
            ]);

            return $this;
        }

        /**
         * CASE 2
         * Customer is updating there max bid
         * This shouldnt really touch the auction/state/bids
         *
         * Update MAXBID:amount
         */

        if ($stateLeadingBidId === $this->maxBid->id) {
            return $this;
        }

        /**
         * CASE 3
         * Customers is placing a bid, but there is already another bid by another customer
         * There is already a max bid that is higher than this one
         */
        if ($this->maxBid->amount <= $this->state->maxBid->amount) {
            $this->_runBidProcess(TRUE);

            return $this;
        }

        /**
         * CASE 4
         * Customer is placing a bit, and its the highest bid of all bidders
         */
        if ($this->maxBid->amount > $this->state->maxBid->amount) {
            $this->_runBidProcess(FALSE);

            return $this;
        }

    }

    private function _runBidProcess($outbid = FALSE)
    {
        if ($outbid) {
            Bid::placeBid($this->maxBid->amount, $this->customer, $this->auction);
            Bid::placeBid($this->newAuctionCurrentPrice, $this->state->customer, $this->auction);

            $this->state->maxBid->update([
                'outbid' => FALSE,
            ]);

            $this->state->update([
                'current_price' => $this->newAuctionCurrentPrice,
            ]);

        } else {
            Bid::placeBid($this->state->maxBid->amount, $this->state->customer, $this->auction);
            Bid::placeBid($this->newAuctionCurrentPrice, $this->customer, $this->auction);

            $this->state->update([
                'current_price' => $this->newAuctionCurrentPrice,
                'leading_id'    => $this->maxBid->id,
            ]);

            $this->state->maxBid->update([
                'outbid' => TRUE,
            ]);

        }

        $this->maxBid->update([
            'outbid' => $outbid,
        ]);

        return $this;
    }

    public function failed($exception)
    {

    }
}
