<?php

namespace App\Model\Customer;

use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class Customer extends Model
{
    protected $hideArray = ['email', 'first_name', 'last_name', 'full_name'];
    protected $table     = 'customers';
    protected $perPage   = 100;
    protected $fillable  = ['email', 'first_name', 'last_name'];
    protected $appends   = [
        'full_name',
    ];
    protected $casts     = [
        'full_name'   => 'string',
        'approved'    => 'bool',
        'platform_id' => 'int',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function auctionsBidOn()
    {

        return $this->hasManyThrough(Auction::class, MaxBid::class, 'customer_id', 'id', 'id', 'auction_id')->orderBy('id', 'desc');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function hideValues()
    {
        $attributes = Arr::only($this->attributesToArray(), $this->hideArray);

        $newValues = [];
        foreach ($attributes as $key => $value) {
            $length          = Str::length($value);
            $newValues[$key] = substr_replace($value, '...', 1, $length - 2);
        }

        $newAttributes = array_merge($this->attributesToArray(), $newValues);

        return $newAttributes;
    }

}
