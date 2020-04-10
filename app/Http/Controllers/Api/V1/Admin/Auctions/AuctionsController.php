<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminAuctionStore;
use App\Http\Requests\AdminAuctionUpdate;
use App\Model\Product\Product;
use Illuminate\Http\Request;
use App\Model\Store\Store;
use App\Model\Auction\Auction;
use Illuminate\Support\Arr;

class AuctionsController extends AdminController
{
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

//        $request = Arr::dot($request->validated());

        /**
         * We find a product based on 3 product criterias
         * Store_Id
         * Platform_Id
         * SKU
         *
         * This should technically always return a single product, if not AdminAuctionStore will catch it and error out before even getting here
         *
         */
        $product = Product::firstOrCreate([
            ['store_id', Store::getCurrentStore()->id],
            ['platform_id', $request->input('product.platform_id')],
            ['sku', $request->input('product.sku')],
        ], [
            'store_id'    => Store::getCurrentStore()->id,
            'platform_id' => $request->input('product.platform_id'),
            'sku'         => $request->input('product.sku'),
            'name'        => $request->input('product.name'),
            'description' => $request->input('product.description'),
            'image_url'   => $request->input('product.image_url'),
            'product_url' => $request->input('product.product_url'),
        ]);


        $auction = new Auction([
            'name'          => $request->input('auction.name'),
            'status'        => $request->input('auction.status'),
            'initial_price' => $request->input('auction.starting_price'),
            'min_bid'       => $request->input('auction.min_bid'),
            'is_buyout'     => $request->input('auction.is_buyout'),
            'buyout_price'  => $request->input('auction.buyout_price'),
            'start_date'    => $request->input('auction.start_date'),
            'end_date'      => $request->input('auction.end_date'),
        ]);

        $auction->store()->associate(Store::getCurrentStore());
        $auction->product()->associate($product);
        $auction->save();


        return $auction;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction $auctions)
    {
        return 'Auctions Edit';
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
