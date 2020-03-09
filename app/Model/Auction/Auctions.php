<?php

namespace App\Model\Auction;

use App\Model\Product\Products;
use Illuminate\Database\Eloquent\Model;

class Auctions extends Model
{
    const ENABLED = 1;
    const DISABLED = 0;

    protected $table = 'auctions';
    public $timestamps = true;
    protected $fillable = ['name'];
    protected $hidden = ['store_id', 'created_at', 'updated_at', 'initial_price', 'buyout_price'];
    protected $appends = ['initial_price_cents', 'buyout_price_cents'];
    protected $with = ['product'];


    protected $casts = [
        'initial_price_cents' => 'int',
        'buyout_price_cents' => 'int'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
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

}
