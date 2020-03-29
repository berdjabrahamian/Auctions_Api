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
    protected $hidden     = [
        'store_id',
    ];
    protected $appends    = ['amount_cents'];
    protected $casts      = [
        'amount_cents' => 'int',
        'outbid'       => 'bool',
    ];

    protected $dispatchesEvents = [
        'updating' => UpdatingMaxBidEvent::class,
    ];

    /**
     * We transform the amount attribute, which is a dollar value into cents and give it its own attribute;
     * @return int
     */
    public function getAmountCentsAttributes(): int
    {
        return $this->amount * 100;
    }

}
