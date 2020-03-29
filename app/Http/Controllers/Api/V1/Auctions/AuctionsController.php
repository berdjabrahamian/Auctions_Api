<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Model\Auction\Auction;
use App\Model\Store\Store;

class AuctionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auction::store()->get([
            'id',
            'product_id',
            'name',
            'status',
            'min_bid',
            'is_buyout',
            'start_date',
            'end_date',
            'initial_price',
            'buyout_price',
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auction = Auction::where([
            ['id', $id],
            ['store_id', Store::getCurrentStore()->id],
        ])->firstOrFail();

        return $auction;
    }
}
