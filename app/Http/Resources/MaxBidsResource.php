<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaxBidsResource extends JsonResource
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
            'id'           => $this->id,
            'auction_id'   => $this->auction_id,
            'customer_id'  => $this->customer_id,
            'outbid'       => $this->outbid,
            'amount_cents' => $this->amount_cents,
            'auction'      => $this->whenLoaded('auction', $this->auction),
        ];
    }
}
