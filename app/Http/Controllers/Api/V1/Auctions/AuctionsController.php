<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\AuctionIndex;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\AuctionsCollection;
use App\Model\Auction\Auction;
use App\Model\Store\Store;
use Illuminate\Http\Request;

class AuctionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @see Auction::scopeWithCustomerMaxBid()
     * @see Auction::scopeByStore()
     * @see Auction::scopeWithAuctionIds()
     * @see Auction::scopeWithAuctionIds()
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuctionIndex $request)
    {
        $auctions = Auction::byStore();
        $auctions = $auctions->orderBy('auctions.id', 'asc');


        //We get an array of auction_ids
        if ($request->has('auction_ids')) {
            $auctions->withAuctionIds($request->get('auction_ids'));
        }

        //We get an array of product_id
        if ($request->has('product_ids')) {
            $auctions->withProductIds($request->get('product_ids'));
        }

        //We get a customer Id
        if ($request->has('customer_id')) {
            $auctions->withCustomerMaxBid($request->get('customer_id'));
        }

        if (!$request->hasAny(['auction_ids', 'product_ids'])) {
            $auctions = $auctions->paginate();
        } else {
            $auctions = $auctions->get();
        }

        return new AuctionsCollection($auctions->load(['product', 'bids']));
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
        ])->with('product');

        if ($request->has('customer_id')) {
            $auction->withCustomerMaxBid($request->get('customer_id'));
        }

        $auction = $auction->firstOrFail();

        return new AuctionResource($auction);
    }
}
