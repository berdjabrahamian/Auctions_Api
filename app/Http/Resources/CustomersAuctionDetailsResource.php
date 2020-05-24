<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomersAuctionDetailsResource extends JsonResource
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
            'auction_end_state'    => $this->when($this->has_ended, $this->auction_end_state, NULL),
            'hammer_price'         => $this->when($this->has_ended, $this->hammer_price, NULL),
            'hammer_price_premium' => $this->when($this->has_ended, $this->hammer_price_with_premium, NULL),
            'winner_id'            => $this->when($this->winning_customer_id, $this->winning_customer_id, NULL),
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            'max_bid'              => [
                'outbid' => $this->outbid,
                'amount' => $this->max_bid_amount,
            ],
            'product'              => $this->whenLoaded('product', $this->_product($this->product)),
        ];
    }

    protected function _product($product)
    {
        return [
            'platform_id'       => $product->platform_id,
            'sku'               => $product->sku,
            'name'              => $product->name,
            'description'       => $product->description,
            'image_url'         => $product->image_url,
            'product_url'       => $product->product_url,
            'short_description' => $product->short_description,
        ];
    }
}
