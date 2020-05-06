<?php

namespace App\Http\Resources;

use App\Model\Auction\Log;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\Types\Parent_;

class AdminLogsCollection extends ResourceCollection
{

    public $collects = AdminLogsResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
//        return $this->_paginate($request);
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
