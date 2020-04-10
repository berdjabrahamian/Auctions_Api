<?php

namespace App\Model\Customer;

use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $table    = 'customers';
    protected $fillable = ['email', 'first_name', 'last_name'];

//    public function setStoreIdAttribute($value)
//    {
//        $this->store_id = Store::getCurrentStore()->id;
//    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

}
