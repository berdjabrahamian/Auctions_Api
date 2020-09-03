<?php


namespace App\Model\Auction\MaxBid;


use App\Model\Auction\Bid;

abstract class GenerateMaxBidAbstract
{

    protected $maxBid;
    protected $customer;
    protected $auction;
    protected $state;
    public    $stateLeadingBidId;
    public    $newAuctionPrice;


    /**
     *
     * @return mixed
     */
    public function getStateLeadingBidId()
    {
        return $this->stateLeadingBidId;
    }

    /**
     * @param  mixed  $stateLeadingBidId
     */
    public function setStateLeadingBidId($stateLeadingBidId): void
    {
        $this->stateLeadingBidId = $stateLeadingBidId;
    }

    /**
     * @param  mixed  $newAuctionPrice
     */
    public function setNewAuctionPrice($newAuctionPrice): void
    {
        $this->newAuctionPrice = $newAuctionPrice;
    }

    /**
     * @return mixed
     */
    public function getNewAuctionPrice()
    {
        return $this->newAuctionPrice;
    }

    /**
     * Update the auction state
     */
    protected function _updateState()
    {
        $this->state->update([
            'leading_id'    => $this->maxBid->id,
            'current_price' => $this->getNewAuctionPrice(),
        ]);
    }


    public abstract function handle();

    protected abstract function _calculateNewAuctionPrice();

    protected abstract function _runBidProcess();

}
