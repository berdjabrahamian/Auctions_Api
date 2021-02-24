<?php


// TODO: Fix the comments as the CASES have been shifted
// TODO: COme back to this as its getting out of hand


namespace App\Model\Auction\MaxBid;

use App\Exceptions\GenerateNewMaxBidException;
use App\Model\Auction\Auction;
use App\Model\Auction\Bid;
use App\Model\Auction\MaxBid;
use App\Model\Auction\State;
use App\Model\Customer\Customer;

class GenerateMinBid extends GenerateBidAbstract {


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
        }

        /**
         * CASE 2
         * Customer is updating there max bid
         * This shouldnt really touch the auction/state/bids
         *
         * Update MAXBID:amount
         */

        if ($this->getStateLeadingBidId() === $this->maxBid->id) {
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


        throw new GenerateNewBidException(
            'There was a problem creating a bid. Please try again later.'
        );
    }


    protected function _runBidProcess($outbid = FALSE)
    {
        if ($outbid) {
            Bid::placeBid($this->maxBid->amount, $this->customer, $this->auction);
            Bid::placeBid($this->getNewAuctionPrice(), $this->state->customer, $this->auction);

            $this->state->maxBid->update([
                'outbid' => FALSE,
            ]);

            $this->state->update([
                'current_price' => $this->getNewAuctionPrice(),
            ]);

        } else {
            Bid::placeBid($this->state->maxBid->amount, $this->state->customer, $this->auction);
            Bid::placeBid($this->getNewAuctionPrice(), $this->customer, $this->auction);

            $this->state->update([
                'current_price' => $this->getNewAuctionPrice(),
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

    /**
     * HOLY CRAP
     *
     * There is a lot of variables here that can make the auction bid go haywire
     * We need to very specific when a bid is placed on how to calculate new auction price
     *
     * @return mixed
     */
    protected function _calculateNewAuctionPrice()
    {

        //Lets see if the current state has a max bid or not
        $stateLeadingMaxBidAmount = $this->state->maxBid ? $this->state->maxBid->amount : 0;

        /**
         * CASE 1
         * First auction bid
         *
         * This is the first bid of an auction
         */
        if (!$this->state->leading_id) {
            $this->setNewAuctionPrice($this->state->current_price + $this->auction->bid_amount);
            return $this;
        }

        /**
         * CASE 2
         * Customer updating max bid
         * Ths customer is just updating there max bid
         */
        if ($this->getStateLeadingBidId() == $this->maxBid->id) {
            $this->setNewAuctionPrice($this->state->current_price);
            return $this;
        }

        /**
         * CASE 3
         * Customers bid is less than the current winners max bid
         */
        if ($this->maxBid->amount < $stateLeadingMaxBidAmount) {
            $this->setNewAuctionPrice($this->maxBid->amount + $this->auction->min_bid);
            return $this;
        }

        /**
         * CASE 4
         * Customers bid is equal to the current winners max bid
         */
        if ($this->maxBid->amount == $stateLeadingMaxBidAmount) {
            $this->setNewAuctionPrice($this->maxBid->amount);
            return $this;
        }

        /**
         * CASE 5
         * Customers bid is greater than the current winners max bid
         */
        if ($this->maxBid->amount > $stateLeadingMaxBidAmount) {
            $this->setNewAuctionPrice($stateLeadingMaxBidAmount + $this->auction->min_bid);
            return $this;
        }


//        //Lets see if the current state has a max bid or not
//        $stateLeadingMaxBidAmount = $this->state->maxBid ? $this->state->maxBid->amount : 0;
//
//        /**
//         * CASE 1
//         * First auction bid
//         *
//         * This is the first bid of an auction
//         */
//        if (!$this->state->leading_id) {
//            $this->setNewAuctionPrice($this->state->current_price + $this->auction->bid_amount);
//            return $this;
//        }
//
//        /**
//         * CASE 2
//         * Customer updating max bid
//         * Ths customer is just updating there max bid
//         */
//        if ($this->getStateLeadingBidId() == $this->maxBid->id) {
//            $this->setNewAuctionPrice($this->state->current_price);
//            return $this;
//        }
//
//
//        /**
//         * There are multiple implementations here where we need to be very careful
//         *
//         * new_bid = 95
//         * top_max_bid = 100
//         * current_auction_price = 90
//         * bid_amount = 5
//         * min_bid = 5
//         *
//         *
//         * CASE 1
//         * new_bid == top_max_bid
//         * new_auction_price = top_max_bid
//         *
//         * CASE 2
//         * new_bid + min_bid == top_max_bid
//         * new_auction_price = top_max_bid
//         *
//         * CASE 3
//         * new_bid + min_bid < top_max_bid - min_bid
//         * new_auction_price = new_bid + min_bid
//         *
//         * CASE 4
//         * new_bid + min_bid > top_max_bid - min_bid
//         * new_auction_price = top_max_bid
//         *
//         *
//         *
//         */
//
//        // CASE 1
//        // CASE 2
//        if ($this->maxBid->amount == $stateLeadingMaxBidAmount) {
//            $this->setNewAuctionPrice($this->maxBid->amount);
//            return $this;
//        }
//
//
//
//
//        // Case 3
//        if ($this->maxBid->amount + $this->auction->min_bid <= $stateLeadingMaxBidAmount - $this->auction->min_bid) {
//            $this->setNewAuctionPrice($this->maxBid->amount + $this->auction->min_bid);
//            return $this;
//        }
//
//        // Case 4
//        if ($this->maxBid->amount + $this->auction->min_bid > $stateLeadingMaxBidAmount - $this->auction->min_bid) {
//            $this->setNewAuctionPrice($stateLeadingMaxBidAmount);
//            return $this;
//        }
//
//
//        /**
//         * CASE 5
//         * Customers bid is greater than the current winners max bid
//         */
//        if ($this->maxBid->amount > $stateLeadingMaxBidAmount) {
//            $this->setNewAuctionPrice($stateLeadingMaxBidAmount + $this->auction->min_bid);
//            return $this;
//        }


        /**
         * ERROR
         * None of the above cases matched, so something is wrong
         */
        throw new GenerateNewMaxBidException(
            'Unable to generate an auction bid, please try again later.', 409
        );

    }


}
