<?php

namespace App\Model\Auction;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table      = 'states';
    public    $timestamps = true;
    protected $guarded    = ['id'];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
}
