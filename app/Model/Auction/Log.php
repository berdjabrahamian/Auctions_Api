<?php

namespace App\Model\Auction;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table      = 'logs';
    public    $timestamps = true;
    protected $hidden     = ['store_id'];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
}
