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


    public static function newOrUpdate($customerData)
    {
        $customer = Customer::updateOrCreate(
            [
                ['platform_id', $customerData['id']],
                ['store_id', Store::getCurrentStore()->id],
            ],
            [
                'first_name' => $customerData['first_name'],
                'last_name'  => $customerData['last_name'],
                'email'      => $customerData['email'],
            ]);

        $customer->platform_id = $customerData['id'];
        $customer->store()->associate(Store::getCurrentStore());
        $customer->save();

        return $customer;
    }

}
