<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminAuctionIndex;
use App\Http\Requests\AdminAuctionStore;
use App\Http\Requests\AdminAuctionUpdate;
use App\Http\Resources\AdminAuctionCollection;
use App\Http\Resources\AdminAuctionResource;
use App\Model\Product\Product;
use Illuminate\Http\Request;
use App\Model\Store\Store;
use App\Model\Auction\Auction;
use Illuminate\Support\Arr;

class AuctionsController extends AdminController
{
    public function index(AdminAuctionIndex $request)
    {
        $auctions = Auction::byStore()->orderBy('auctions.id', 'asc')->get();

        return new AdminAuctionCollection($auctions->load('bids'));
    }


    /**
     * Grab an already imported product or create a new one if it doesnt exist
     * Create a auction
     * Connect the auction to the store it belongs to
     * Associate the product to the auction
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdminAuctionStore $request)
    {
        $validated = Arr::dot($request->validated());

        /**
         * This should technically always return a single product, if not AdminAuctionStore will catch it and error out before even getting here
         */
        $product = $request->getProduct();

        $auction = new Auction([
            'name'          => $validated['auction.name'],
            'status'        => $validated['auction.status'],
            'initial_price' => $validated['auction.starting_price'],
            'min_bid'       => $validated['auction.min_bid'],
            'is_buyout'     => $validated['auction.is_buyout'],
            'buyout_price'  => $validated['auction.buyout_price'],
            'start_date'    => $validated['auction.start_date'],
            'end_date'      => $validated['auction.end_date'],
        ]);

        $auction->store()->associate(Store::getCurrentStore());
        $auction->product()->associate($product);
        $auction->save();

        return new AdminAuctionResource($auction);
    }


    public function show(Auction $auction)
    {
        return new AdminAuctionResource($auction->load(['logs']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Model\Auction\Auction  $auctions
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AdminAuctionUpdate $request, Auction $auction)
    {
        $auction->update($request->toArray());

        return $auction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auctions)
    {
        //
    }

}
