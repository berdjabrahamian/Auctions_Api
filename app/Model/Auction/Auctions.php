<?php

namespace App\Model\Auction;

use App\Model\Product\Products;
use Illuminate\Database\Eloquent\Model;

class Auctions extends Model
{
    const ENABLED = 1;
    const DISABLED = 0;

    protected $table = 'auctions';
    public $timestamps = true;
    protected $fillable = ['title'];

    protected $hidden = ['store_id', 'created_at', 'updated_at'];


    public function product()
    {
        return $this->hasOne(Products::class);
    }

}
