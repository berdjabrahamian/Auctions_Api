<?php

namespace App\Model\Auction;

use App\Model\Store\Store;
use App\Model\Auction\Auction;
use App\Model\Customer\Customer;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table      = 'bids';
    public    $timestamps = TRUE;
    protected $fillable   = [];
    protected $with       = ['customer'];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
