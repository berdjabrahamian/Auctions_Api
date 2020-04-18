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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Auction extends Model
{
    protected $table      = 'auctions';
    public    $timestamps = TRUE;
    protected $perPage    = 100;
    protected $guarded    = [
        'id',
        'store_id',
        'product_id',
    ];
    protected $hidden     = [
        'store_id',
        'created_at',
        'updated_at',
        'min_bid',
        'initial_price',
        'buyout_price',
    ];
    protected $appends    = [
//        'current_price',
//        'initial_price',
//        'hammer_price_cents',
//        'min_bid_cents',
//        'buyout_price_cents',
    ];
    protected $casts      = [
        'current_price' => 'int',
        'initial_price' => 'int',
        //        'min_bid_cents'      => 'int',
        //        'buyout_price_cents' => 'int',
        //        'hammer_price'       => 'int',
        //        'hammer_price_cents' => 'int',
    ];
    protected $dates      = [
        'start_date',
        'end_date',
    ];


    //////////////////////
    /// RELATIONSHIPS ///
    ////////////////////

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

    public function customers()
    {
        return $this->hasManyThrough(Customer::class, Bid::class, 'auction_id', 'id', 'id', 'customer_id');
    }


    ///////////////////////
    ///// Attributes /////
    /////////////////////

    public function setInitialPriceAttribute($value)
    {
        $this->attributes['initial_price'] = $value * 100;
    }

    public function getInitialPriceAttribute(): int
    {
        return $this->initial_price / 100;
    }

    public function setCurrentPriceAttribute($value)
    {
        $this->attributes['current_price'] = $value * 100;
    }

    public function getCurrentPriceAttribute(): int
    {
        return $this->current_price / 100;
    }

    public function setHammerPriceAttribute()
    {
        $this->attributes['hammer_price'] = $value * 100;
    }

    public function getHammerPriceAttribute(): int
    {
        return $this->hammer_price / 100;
    }

    public function setMinBidAttribute($value)
    {
        $this->attributes['min_bid'] = $value * 100;
    }

    public function getMinBidAttribute(): int
    {
        return $this->min_bid * 100;
    }

    public function setBuyoutPriceAttribute($value)
    {
        $this->attributes['buyout_price'] = $value * 100;
    }

    public function getBuyoutPriceAttribute(): int
    {
        return $this->buyout_price / 100;
    }





    public function getBidsCountAttribute(): int
    {
        return $this->bids->count();
    }

    public function getHasEndedAttribute(): bool
    {
        return $this->end_date < Carbon::now();
    }

    public function getEndingSoonDate()
    {
        $endDate          = $this->end_date;
        $notificationTime = $this->store->ending_soon_notification;

        $endingSoonDate = $endDate->subHours($notificationTime);

        return $endingSoonDate;
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
        return $query->where('auctions.store_id', Store::getCurrentStore()->id);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return mixed
     */
    public function scopeWithAuctionIds($query, $auctionIds)
    {
        $withActionIds = $query->whereRaw("auctions.id in ({$auctionIds})");
        return $withActionIds;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param                                         $productIds
     *
     * @return mixed
     */
    public function scopeWithProductIds($query, $productIds)
    {
        $withProductIds = $query->whereRaw("auctions.product_id in ({$productIds})");
        return $withProductIds;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param                                         $customer_id
     *
     * @return mixed
     */
    public function scopeWithCustomerMaxBid($query, $customer_id)
    {
        $customerMaxBids = $query->leftJoin('max_bids', function ($leftJoin) use ($customer_id) {
            $leftJoin->on('auctions.id', '=', 'max_bids.auction_id')
                ->where('max_bids.customer_id', '=', $customer_id);
        });

        $customerMaxBids->select('auctions.*', 'max_bids.id AS max_bid_id', 'max_bids.amount AS max_bid_amount',
            'max_bids.outbid AS max_bid_outbid');

        return $customerMaxBids;
    }

    /**
     * @param  MaxBid  $maxBid
     * @param  State   $state
     *
     * @see GenerateBids::handle() //This will have details description of what each case means
     * @return int|mixed
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

    public static function updateState(State $state)
    {
        $auction = $state->auction;

        $auction->update([
            'current_price'      => $state->current_price,
            'leading_max_bid_id' => $state->leading_id,
        ]);

    }

    /**
     * This checks to see if the auction is bid within
     *
     * @return bool
     */
    public function isLastMinuteBid(): bool
    {
        $storeThreshold = $this->store->final_extension_threshold;
        $diffInMinutes  = Carbon::now()->diffInMinutes($this->end_date);

        return $diffInMinutes <= $storeThreshold;

    }

    public function getHammerPrice()
    {
        return $this->current_price;
    }

    public function getHammerPriceWithPremium()
    {
        $storeHammerPrice = $this->store->hammer_price;
        $storeHammerType  = $this->store->hammer_type;


        if ($storeHammerType == 1) {
            return $this->getHammerPrice() + $storeHammerPrice;
        } else {
            return ($this->getHammerPrice() * $storeHammerPrice / 100) + $this->getHammerPrice();
        }
    }

}
