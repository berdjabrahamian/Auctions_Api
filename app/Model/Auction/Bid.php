<?php

namespace App\Model\Auction;

use App\Model\Store\Store;
use App\Model\Auction\Auction;
use App\Model\Customer\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table      = 'bids';
    public    $timestamps = TRUE;
    protected $fillable   = [];
    protected $appends    = [
        'bid_placed',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function getBidPlacedAttribute()
    {
        return Carbon::make($this->created_at)->diffForHumans();
    }

    public static function placeBid($bidAmount, Customer $customer, Auction $auction)
    {
        $bid              = new Bid();
        $bid->store_id    = $customer->store_id;
        $bid->auction_id  = $auction->id;
        $bid->customer_id = $customer->id;
        $bid->amount      = $bidAmount;

        $bid->save();

        return $bid;
    }
}
