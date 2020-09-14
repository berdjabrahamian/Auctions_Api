<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuctionShowLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'activity' => $this->activity,
            'created_at' => $this->created_at,
            'amount' => $this->amount,
            'customer' => new AdminAuctionShowLogCustomer($this->customer),
        ];
    }
}
