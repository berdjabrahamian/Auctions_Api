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
    public    $timestamps = true;
    protected $guarded    = ['id', 'store_id', 'product_id'];
    protected $hidden     = ['store_id', 'created_at', 'updated_at', 'min_bid', 'initial_price', 'buyout_price'];
    protected $appends    = ['min_bid_cents', 'initial_price_cents', 'buyout_price_cents'];
    protected $with       = ['product', 'logs'];
    protected $casts      = [
        'min_bid_cents'       => 'ind',
        'initial_price_cents' => 'int',
        'buyout_price_cents'  => 'int',
    ];


    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @see Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @see Log
     */
    public function logs()
    {
        return $this->hasMany(Log::class, 'auction_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @see Bid
     */
    public function bids()
    {
        return $this->hasMany(Bid::class, 'bid_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @see State
     */
    public function state()
    {
        return $this->hasOne(State::class, 'auction_id', 'id');
    }

    public function setCurrentPriceAttribute($value)
    {
        $this->attributes['current_price'] = $value * 100;
    }


    public function getMinBidCentsAttribute(): int
    {
        return $this->min_bid * 100;
    }

    /**
     * We transform the initial_price attribute, which is a dollar value into cents and give it its own attribute;
     * @return int
     */
    public function getInitialPriceCentsAttribute(): int
    {
        return $this->initial_price * 100;
    }

    /**
     * We transform the buyout_price attribute, which is a dollar value into cents and give it its own attribute;
     * @return int
     */
    public function getBuyoutPriceCentsAttribute(): int
    {
        return $this->buyout_price * 100;
    }

    /**
     * We are creating a local query scope that we only load the models that belong to the store from the public-key within the middleware
     * @param $query
     * @return mixed
     * @see Store::getCurrentStore()
     */
    public function scopeByStore($query)
    {
        return $query->where('store_id', Store::getCurrentStore()->id);

    }

    /**
     * @param  MaxBid  $maxBid
     * @param  State  $state
     * @return mixed
     */
    public function newCurrentPrice(MaxBid $maxBid, State $state)
    {
        /**
         * CASE 1
         */
        if (!$state->leading_id) {
            return $this->current_price + ($this->min_bid_cents);
        }


        /**
         * CASE 2
         */


    }


    public function calculateNewCurrentPrice($price)
    {
        $auctionMinBid = $this->min_bid;
        $auctionPrice  = $this->current_price ? $this->current_price : $this->amount;
    }


    public function placeBid($bidAmount, Customer $customer)
    {

        $bid              = new Bid();
        $bid->store_id    = Store::getCurrentStore()->id;
        $bid->auction_id  = $this->id;
        $bid->customer_id = $customer->id;
        $bid->amount      = $bidAmount;

        $bid->save();

        return $bid;

    }


}
