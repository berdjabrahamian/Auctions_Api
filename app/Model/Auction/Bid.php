<?php

namespace App\Model\Auction;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table      = 'bids';
    public    $timestamps = true;


    public function auction()
    {
        return $this->belongsTo(Auction::class, 'id', 'auction_id');
    }

}
