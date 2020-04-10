<?php

namespace App\Model\Auction;

use App\Events\CreatedAuctionEvent;
use App\Jobs\GenerateAuctionLog;
use App\Jobs\GenerateBids;
use App\Model\Customer\Customer;
use App\Model\Product\Product;
use App\Model\Auction\Log;
use App\Model\Auction\Bid;
use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table      = 'auctions';
    public    $timestamps = TRUE;
    protected $guarded    = ['id', 'store_id', 'product_id'];
    protected $hidden     = ['store_id', 'created_at', 'updated_at', 'min_bid', 'initial_price', 'buyout_price'];
    protected $appends    = ['current_price_cents', 'min_bid_cents', 'initial_price_cents', 'buyout_price_cents'];
    protected $with       = ['product', 'logs'];
    protected $casts      = [
        'current_price_cents' => 'int',
        'min_bid_cents'       => 'int',
        'initial_price_cents' => 'int',
        'buyout_price_cents'  => 'int',
    ];


    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    /**
     * @see Product
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @see Log
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class, 'auction_id', 'id');
    }

    /**
     * @see Bid
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids()
    {
        return $this->hasMany(Bid::class, 'auction_id', 'id');
    }

    /**
     * @see State
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function state()
    {
        return $this->hasOne(State::class, 'auction_id', 'id');
    }


    public function getCurrentPriceCentsAttribute(): int
    {
        return $this->current_price * 100;
    }

    public function getMinBidCentsAttribute(): int
    {
        return $this->min_bid * 100;
    }

    /**
     * We transform the initial_price attribute, which is a dollar value into cents and give it its own attribute;
     *
     * @return int
     */
    public function getInitialPriceCentsAttribute(): int
    {
        return $this->initial_price * 100;
    }

    /**
     * We transform the buyout_price attribute, which is a dollar value into cents and give it its own attribute;
     *
     * @return int
     */
    public function getBuyoutPriceCentsAttribute(): int
    {
        return $this->buyout_price * 100;
    }

    /**
     * We are creating a local query scope that we only load the models that belong to the store from the public-key
     * within the middleware
     *
     * @param $query
     *
     * @see Store::getCurrentStore()
     * @return mixed
     */
    public function scopeByStore($query)
    {
        return $query->where('store_id', Store::getCurrentStore()->id);

    }

    /**
     * @param  MaxBid  $maxBid
     * @param  State   $state
     *
     * @return mixed
     */
    public function newCurrentPrice(MaxBid $maxBid, State $state)
    {
        $stateLeadingMaxBidAmount = $state->maxBid ? $state->maxBid->amount : 0;

        /**
         * CASE 1
         * First auction bid
         */
        if (!$state->leading_id) {
            return $state->current_price + $this->min_bid;
        }

        /**
         * CASE 2
         * Customer updating max bid
         */
        if ($state->leading_id == $maxBid->id) {
            return $state->current_price;
        }

        /**
         * CASE 3
         * Customers bid is less than the current winners max bid
         */
        if ($maxBid->amount < $stateLeadingMaxBidAmount) {
            return $maxBid->amount + $this->min_bid;
        }

        /**
         * CASE 4
         * Customers bid is equal to the current winners max bid
         */
        if ($maxBid->amount == $stateLeadingMaxBidAmount) {
            return $maxBid->amount;
        }

        /**
         * CASE 5
         * Customers bid is greater than the current winners max bid
         */
        if ($maxBid->amount > $stateLeadingMaxBidAmount) {
            return $stateLeadingMaxBidAmount + $this->min_bid;
        }

        return $stateLeadingMaxBidAmount;
    }


    /**
     * @param            $bidAmount
     * @param  Customer  $customer
     *
     * @return \App\Model\Auction\Bid
     */
    public function placeBid($bidAmount, Customer $customer)
    {
        $bid              = new Bid();
        $bid->store_id    = $customer->store_id;
        $bid->auction_id  = $this->id;
        $bid->customer_id = $customer->id;
        $bid->amount      = $bidAmount;

        $bid->save();

        $this->update([
            'current_price' => $bidAmount,
        ]);

        return $bid;

    }

}
