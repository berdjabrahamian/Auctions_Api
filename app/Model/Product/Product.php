<?php

namespace App\Model\Product;

use App\Model\Auction\Auction;
use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table      = 'products';
    public    $timestamps = TRUE;
    protected $fillable   = [];
    protected $hidden     = ['id', 'store_id', 'created_at', 'updated_at'];
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

}


