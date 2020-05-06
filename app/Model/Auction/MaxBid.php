<?php

namespace App\Model\Auction;

use App\Model\Customer\Customer;
use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Model;

class MaxBid extends Model
{
    protected $table      = 'max_bids';
    public    $timestamps = TRUE;
    protected $fillable   = [
        'store_id',
        'auction_id',
        'customer_id',
        'amount',
        'outbid',
    ];
    protected $appends    = [
        'amount_cents',
    ];
    protected $casts      = [
        'amount_cents' => 'int',
        'outbid'       => 'bool',
    ];


    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id')->withoutGlobalScope('StoreScope');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    /**
     * We transform the amount attribute, which is a dollar value into cents and give it its own attribute;
     *
     * @return int
     */
    public function getAmountCentsAttribute(): int
    {
        return $this->amount * 100;
    }

}
