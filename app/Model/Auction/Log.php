<?php

namespace App\Model\Auction;

use App\Model\Customer\Customer;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table      = 'logs';
    public    $timestamps = TRUE;
    protected $hidden     = ['store_id'];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'id', 'customer_id');
    }
}
