<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    /**
     * TODO: finalise the PRODUCT Resource
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                         => $this->id,
            'name'                       => $this->name,
            'status'                     => $this->status,
            'is_buyout'                  => $this->is_buyout,
            'start_date'                 => $this->start_date,
            'end_date'                   => $this->end_date,
            'has_ended'                  => $this->has_ended,
            'initial_price_cents'        => $this->initial_price_cents,
            'current_price_cents'        => $this->current_price_cents,
            'hammer_price_cents'         => $this->when($this->has_ended, $this->hammer_price_cents),
            'hammer_price_premium_cents' => $this->when($this->has_ended, $this->hammer_price_premium_cents),
            'winning_bid_id'             => NULL,
            'bids_count'                 => $this->whenLoaded('bids',$this->bids_count),
            'current_user_bid'           => $this->_currentUser($request),
            'product'                    => new ProductResource($this->whenLoaded('product')),
        ];
    }

    /**
     * @param $request
     *
     * @return array
     */
    private function _currentUser($request): array
    {
        if ($this->max_bid_amount) {
            return [
                'max_bid_amount' => $this->max_bid_amount,
                'outbid'         => $this->max_bid_outbid,
            ];
        } else {
            return [];
        }
    }
}
