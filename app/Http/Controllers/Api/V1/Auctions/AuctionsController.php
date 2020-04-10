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
        $auctions = Auction::byStore()->setEagerLoads([])->get();
        return $auctions;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     *
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
