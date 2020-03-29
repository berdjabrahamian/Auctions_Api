<?php

namespace App\Model\Auction;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table      = 'states';
    public    $timestamps = true;
    protected $fillable   = [
        'auction_id',
        'leading_id',
        'current_price',
    ];


    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
}
