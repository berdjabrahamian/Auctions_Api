<?php

namespace App\Model\Product;

use App\Model\Auction\Auction;
use App\Model\Store\Store;
use App\Scope\StoreScope;
use App\Traits\PublicId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use PublicId;


    protected $table      = 'products';
    public    $timestamps = TRUE;
    protected $perPage    = 100;
    protected $appends    = [
        'short_description',
    ];
    protected $casts      = [
        'short_description' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auction()
    {
        return $this->hasOne(Auction::class, 'product_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 75);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param                                         $productIds
     *
     * @return mixed
     */
    public function scopeWithPublicIds($query, $publicIds)
    {
        $withPublicIds = $query->whereRaw("products.pub_id in ({$publicIds})");

        return $withPublicIds;
    }

    public function scopeWithPlatformIds($query, $platformIds) {
        $withPlatformIds = $query->whereRaw("products.platform_id in ({$platformIds})");

        return $withPlatformIds;
    }
}


