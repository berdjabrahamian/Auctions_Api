<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuctionResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'status'        => $this->status,
            'initial_price' => $this->initial_price,
            'min_bid'       => $this->min_bid,
            'is_buyout'     => $this->is_buyout,
            'buyout_price'  => $this->buyout_price,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'logs'          => $this->whenLoaded('logs'),
        ];
    }
}
