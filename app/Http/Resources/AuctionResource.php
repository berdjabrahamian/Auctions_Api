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
            'id'                   => $this->id,
            'name'                 => $this->name,
            'status'               => $this->status,
            'is_buyout'            => $this->is_buyout,
            'start_date'           => $this->start_date,
            'end_date'             => $this->end_date,
            'has_ended'            => $this->has_ended,
            'initial_price'        => $this->initial_price,
            'current_price'        => $this->current_price,
            'bids_count'           => $this->bids_count,
            'auction_end_state'    => $this->when($this->has_ended, $this->auction_end_state),
            'hammer_price'         => $this->when($this->has_ended, $this->hammer_price),
            'hammer_price_premium' => $this->when($this->has_ended, $this->hammer_price_with_premium),
//            'winner_id'            => $this->whenLoaded('maxBid', $this->maxBid),
            'current_user_bid'     => $this->_currentUser($request),
            'product'              => new ProductResource($this->whenLoaded('product')),
        ];
    }

    /**
     * @param $request
     *
     * @return array
     */
    private function _currentUser($request): array
    {
        if ($request->has('customer_id') && $this->current_user_amount) {
            return [
                'amount' => $this->current_user_amount,
                'outbid' => $this->current_user_outbid,
            ];
        } else {
            return [];
        }
    }
}
