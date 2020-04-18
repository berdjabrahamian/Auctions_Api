<?php

namespace App\Http\Resources;

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
        $customerData = $this->_customer($request);

        return [
            'email'       => $customerData['email'],
            'full_name'   => $customerData['full_name'],
            'platform_id' => $customerData['platform_id'],
        ];
    }

    /**
     * @param $request
     *
     * @see Customer::hideValues()
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    private function _customer($request)
    {
        $customer = $this;

        if ($request->has('hidden')) {
            $customer = $customer->hideValues();
        }

        return $customer;
    }
}
