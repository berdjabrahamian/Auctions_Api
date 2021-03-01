<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuctionShowProduct extends JsonResource
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
            'id'          => $this->pub_id,
            'sku'         => $this->sku,
            'platform_id' => $this->platform_id,
            'image_url'   => $this->image_url,
            'product_url' => $this->product_url,
        ];
    }
}
