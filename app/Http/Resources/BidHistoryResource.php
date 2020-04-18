<?php

namespace App\Http\Resources;

use App\Model\Customer\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class BidHistoryResource extends JsonResource
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
        return [
            'id'         => $this->id,
            'amount'     => $this->amount,
            'bid_placed' => $this->bid_placed,
            'created_at' => $this->created_at,
            'customer'   => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
