<?php

namespace App\Model\Auction;

use App\Model\Store\Store;
use App\Model\Auction\Auction;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table      = 'bids';
    public    $timestamps = true;
    protected $fillable = [];


    public function auction()
    {
        return $this->belongsTo(Auction::class, 'id', 'auction_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'id', 'store_id', Auction::class);
    }

}
