<?php

namespace App\Model\Product;

use App\Model\Auction\Auctions;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = ['title'];

    protected $hidden = ['store_id', 'created_at', 'updated_at'];

    public function auction()
    {
        return $this->belongsTo(Auctions::class);
    }
}
