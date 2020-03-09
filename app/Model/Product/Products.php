<?php

namespace App\Model\Product;

use App\Model\Auction\Auctions;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = ['name'];

    protected $hidden = ['id', 'store_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auction()
    {
        return $this->belongsTo(Auctions::class, 'product_id', 'id');
    }
}
