<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminLogsResource extends JsonResource
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
            'id'          => $this->id,
            'activity'    => $this->activity,
            'auction_id'  => $this->auction_id,
            'customer_id' => $this->when($this->customer_id, $this->customer_id, NULL),
            'amount'      => $this->when($this->amount, $this->amount, NULL),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'customer'    => new AdminCustomerResource($this->whenLoaded('customer')),
            'auction'     => new AdminAuctionShowResource($this->whenLoaded('auction')),
        ];
    }
}
