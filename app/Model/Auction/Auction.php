<?php

namespace App\Model\Auction;

use App\Events\CreatedAuctionEvent;
use App\Model\Product\Product;
use App\Model\Auction\Log;
use App\Model\Auction\Bid;
use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table      = 'auctions';
    public    $timestamps = true;
    protected $fillable   = [
        'store_id',
        'product_id',
        'name',
        'status',
        'initial_price',
        'min_bid',
        'is_buyout',
        'buyout_price',
        'start_date',
        'end_date',
    ];
    protected $hidden     = ['store_id', 'created_at', 'updated_at', 'initial_price', 'buyout_price'];
    protected $appends    = ['initial_price_cents', 'buyout_price_cents'];
//    protected $with       = ['product', 'logs'];
    protected $casts            = [
        'initial_price_cents' => 'int',
        'buyout_price_cents'  => 'int',
    ];
    protected $dispatchesEvents = [
        'created' => CreatedAuctionEvent::class,
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @see Product
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
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
     */
    public function state()
    {
        return $this->hasOne(State::class, 'auction_id', 'id');
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
    public function scopeStore($query)
    {
        return $query->where('store_id', Store::getCurrentStore()->id);

    }
}
