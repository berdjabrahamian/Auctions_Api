<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuctionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */

    public $collection = Auction::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
