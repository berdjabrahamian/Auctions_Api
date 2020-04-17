<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Auction extends JsonResource
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
            'id'               => $this->id,
            'product_id'       => $this->product_id,
            'name'             => $this->name,
            'status'           => $this->status,
            'is_buyout'        => $this->is_buyout,
            'start_date'       => $this->start_date,
            'end_date'         => $this->end_date,
            'has_ended'        => $this->has_ended,
            'initial_price'    => $this->initial_price_cents,
            'current_price'    => $this->current_price_cents,
            'current_user_bid' => $this->_currentUser($request),
        ];
    }

    private function _currentUser($request)
    {
        if ($this->max_bid_amount) {
            return [
                'max_bid_amount' => $this->max_bid_amount,
                'outbid'         => $this->max_bid_outbid,
            ];
        };

        return NULL;
    }

}
