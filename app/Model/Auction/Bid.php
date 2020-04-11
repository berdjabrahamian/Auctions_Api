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
    protected $hidden     = [
        'updated_at',
        'created_at',
        'store_id',
        'customer_id',
    ];
    protected $with       = ['customer'];
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
}
