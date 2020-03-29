<?php

namespace App\Model\Auction;

use App\Events\UpdatingMaxBidEvent;
use App\Model\Customer\Customer;
use Illuminate\Database\Eloquent\Model;

class MaxBid extends Model
{
    protected $table      = 'max_bids';
    public    $timestamps = true;
    protected $fillable   = ['store_id', 'auction_id', 'customer_id', 'amount', 'outbid'];


    protected $dispatchesEvents = [
        'updating' => UpdatingMaxBidEvent::class,
    ];

}
