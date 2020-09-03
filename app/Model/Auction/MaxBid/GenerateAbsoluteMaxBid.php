<?php


namespace App\Model\Auction\MaxBid;


use App\Exceptions\GenerateNewBidException;
use App\Exceptions\GenerateNewMaxBidException;
use App\Model\Auction\Auction;
use App\Model\Auction\Bid;
use App\Model\Auction\MaxBid;
use App\Model\Auction\State;
use App\Model\Customer\Customer;

class GenerateAbsoluteMaxBid extends GenerateMaxBidAbstract
{


    public function __construct(Customer $customer, MaxBid $maxBid)
    {
        $this->customer = $customer;
        $this->maxBid   = $maxBid;
        $this->auction  = $maxBid->auction;
        $this->state    = $this->auction->state;

        $this->setStateLeadingBidId($this->state->leading_id);
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
     * CASE 5 - Highest Bidder of all bidders
     *
     * @throws GenerateNewMaxBidException
     *
     * @see Auction::newCurrentPrice()
     * @see Auction::placeBid()
     *
     */
    public function handle()
    {

        $this->_calculateNewAuctionPrice();

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
        if (!$this->getStateLeadingBidId()) {
            Bid::placeBid($this->getNewAuctionPrice(), $this->customer, $this->auction);
            $this->_updateState();
            return $this;
        } else {
            $this->_runBidProcess(FALSE);
            return $this;
        }


        throw new GenerateNewMaxBidException('There was a problem creating a bid. Please try again later', 409);
    }


    /**
     * @return mixed
     */
    protected function _calculateNewAuctionPrice()
    {
        //Lets get the auction states current price
        $statesCurrentPrice = $this->state->current_price;


        /**
         * This works a little different
         * The way the absolute auction works is that the users bid is the price they want to pay for an auction
         * So this way you can never bid less than the current price and you will immediately be outbid, so there is no secret max_bid
         */


        /**
         * CASE 1
         * First auction bid
         *
         * This is the first bid of an auction
         *
         */
        if (!$this->state->leading_id) {
            $this->setNewAuctionPrice($this->maxBid->amount);
            return $this;
        }

        $this->setNewAuctionPrice($this->maxBid->amount);
        return $this;
    }


    protected function _runBidProcess($outbid = FALSE)
    {

        Bid::placeBid($this->getNewAuctionPrice(), $this->customer, $this->auction);

        $this->state->update([
            'current_price' => $this->getNewAuctionPrice(),
            'leading_id'    => $this->maxBid->id,
        ]);

        $this->state->maxBid->update([
            'outbid' => TRUE,
        ]);


        $this->maxBid->update([
            'outbid' => $outbid,
        ]);

        return $this;
    }


}
