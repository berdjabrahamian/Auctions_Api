<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuctionShowResource extends JsonResource
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
//        return parent::toArray($request);
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'status'        => $this->status,
            'initial_price' => $this->initial_price,
            'min_bid'       => $this->min_bid,
            'is_buyout'     => $this->is_buyout,
            'buyout_price'  => $this->buyout_price,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'has_started'   => $this->has_started,
            'has_ended'     => $this->has_ended,
            'type'          => $this->type,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'relationships' => [
                'product' => new AdminAuctionShowProduct($this->whenLoaded('product')),
                'logs'    => new AdminAuctionShowLogsCollection($this->whenLoaded('logs')),
            ],

        ];
    }
}
