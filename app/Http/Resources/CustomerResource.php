<?php

namespace App\Http\Resources;

use App\Model\Customer\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $customerData = $this->_customer();

        return [
            'email'       => $customerData['email'],
            'full_name'   => $customerData['full_name'],
            'platform_id' => $customerData['platform_id'],
        ];
    }

    /**
     * @param $request
     *
     * @var $this Customer
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    private function _customer()
    {

        $storeOptions = $this->store->options;

        if ($storeOptions->customer_data_hidden) {
            return $this->hideValues();
        }

        return $this;
    }
}
