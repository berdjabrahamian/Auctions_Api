<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminProductsResource extends JsonResource
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
            'id'                => $this->pub_id,
            'sku'               => $this->sku,
            'platform_id'       => $this->platform_id,
            'name'              => $this->name,
            'decription'        => $this->description,
            'short_description' => $this->short_description,
            'image_url'         => $this->image_url,
            'product_url'       => $this->product_url,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
