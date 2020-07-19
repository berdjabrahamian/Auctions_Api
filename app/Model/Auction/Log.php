<?php

namespace App\Model\Auction;

use App\Model\Customer\Customer;
use App\Model\Store\Store;
use App\Model\Auction\Auction;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table      = 'logs';
    public    $timestamps = TRUE;
    protected $hidden     = ['store_id'];
    protected $perPage    = 100;

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
