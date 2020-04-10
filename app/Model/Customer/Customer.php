<?php

namespace App\Model\Customer;

use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $table    = 'customers';
    protected $fillable = ['email', 'first_name', 'last_name'];
    protected $hidden   = ['first_name', 'last_name', 'created_at', 'updated_at', 'id', 'store_id'];
    protected $appends  = [
        'full_name',
    ];
    protected $casts    = [
        'full_name' => 'string',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

}
