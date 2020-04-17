<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\AuctionIndex;
use App\Http\Resources\AuctionCollection;
use App\Model\Auction\Auction;
use App\Model\Store\Store;

class AuctionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @see Auction::scopeWithCustomerMaxBid()
     * @see Auction::scopeByStore()
     * @see Auction::scopeWithAuctionIds()
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuctionIndex $request)
    {
        $auctions = Auction::byStore()->setEagerLoads([]);

        //We get an array of auction_ids
        if ($request->has('auction_ids')) {
            $auctions->withAuctionIds($request->get('auction_ids'));
        }

        //We get a customer Id
        if ($request->has('customer_id')) {
            $auctions->withCustomerMaxBid($request->get('customer_id'));
        }

        $auctions = $auctions->orderBy('auctions.id', 'asc')->get();
        return new AuctionCollection($auctions);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $auction = Auction::byStore()->where([
            ['auctions.id', $id],
        ]);

        if ($request->has('customer_id')) {
            $auction->withCustomerMaxBid($request->get('customer_id'));
        }

        dd($auction->dd());

        $auction = $auction->firstOrFail();

        return $auction;
    }
}
