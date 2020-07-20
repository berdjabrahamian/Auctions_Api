<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminLogsShowResource extends JsonResource
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
            'product_id'    => $this->product_id,
            'name'          => $this->name,
            'status'        => $this->status,
            'initial_price' => $this->initial_price,
            'min_bid'       => $this->min_bid,
            'is_buyout'     => $this->is_buyout,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'bids_count'    => $this->bids_count,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'logs'          => new AdminLogsCollection($this->logs),
        ];
    }
}
