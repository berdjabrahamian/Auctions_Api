<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomersAuctionsResource extends JsonResource
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
            'email'       => $this->email,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'full_name'   => $this->full_name,
            'platform_id' => $this->platform_id,
            'approved'    => $this->approved,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'auctions'    => new CustomersAuctionDetailsCollection($this->auctions),
        ];
    }
}
