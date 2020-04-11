<?php

namespace App\Model\Product;

use App\Model\Auction\Auction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table      = 'products';
    public    $timestamps = TRUE;
    protected $fillable   = ['store_id', 'sku', 'platform_id', 'name', 'description', 'image_url', 'product_url'];
    protected $hidden     = ['id', 'store_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auction()
    {
        return $this->hasOne(Auction::class, 'product_id', 'id');
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 75);
    }


}
