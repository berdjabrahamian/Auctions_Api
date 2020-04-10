<?php

namespace App\Model\Auction;

use App\Model\Customer\Customer;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table      = 'states';
    public    $timestamps = TRUE;
    protected $guarded    = ['id'];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function maxBid()
    {
        return $this->hasOne(MaxBid::class, 'id', 'leading_id');
    }

    public function customer()
    {
        return $this->hasOneThrough(Customer::class, MaxBid::class,'id', 'id', 'leading_id', 'customer_id');
    }
}
