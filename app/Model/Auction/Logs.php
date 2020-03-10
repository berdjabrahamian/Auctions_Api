<?php

namespace App\Model\Auction;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';
    public $timestamps = true;



    public function auction()
    {
        return $this->belongsTo(Auctions::class, 'auction_id', 'id');
    }
}
