<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminAuctionIndex;
use App\Http\Requests\AdminAuctionShow;
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
        $auctions = Store::getCurrentStore()->auctions()->with('bids')->orderBy('id', 'desc');

        return new AdminAuctionCollection($auctions->paginate());
    }


    /**
     * Grab an already imported product or create a new one if it doesnt exist
     * Create a auction
     * Connect the auction to the store it belongs to
     * Associate the product to the auction
     *
     * @param  AdminAuctionStore  $request
     *
     * @return AdminAuctionResource
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


    public function show($id)
    {
        return new AdminAuctionResource(Store::getCurrentStore()->auctions()->find($id)->load(['logs']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AdminAuctionUpdate  $request
     * @param  Auction             $auction
     *
     * @return Auction
     *
     */
    public function update(AdminAuctionUpdate $request, Auction $auction)
    {
        $validated = Arr::dot($request->validated());

        $auction->update($validated);

        return new AdminAuctionResource($auction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     *
     * @return \Illuminate\Http\Response
     *
     * TODO: Finished Admin Auction Delete - not sure if im going to allow this
     */
    public function destroy(Auction $auctions)
    {
        //
    }

}
