<?php

namespace App\Http\Resources;

use App\Model\Auction\Auction;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class AuctionsCollection extends ResourceCollection
{
    public $collects = AuctionResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
//        if ($request->hasAny(['auction_ids', 'product_ids'])) {
            return parent::toArray($request);
//        } else {
//            return $this->_paginate($request);
//        }
    }

    /**
     * @param  array  $additional
     */
    public function setAdditional(array $additional): void
    {
        $this->additional = $additional;
    }

    protected function _paginate($request)
    {
        $currentPage  = LengthAwarePaginator::resolveCurrentPage();
        $perPage      = $request->get('per_page', 100);
        $path         = $request->fullUrl();
        $currentItems = array_slice($this->collection->toArray(), $perPage * ($currentPage - 1), $perPage);
        $pagination   = new LengthAwarePaginator($currentItems, $this->count(), $perPage, $currentPage,
            ['path' => $path]);

        return $pagination;
    }


}
