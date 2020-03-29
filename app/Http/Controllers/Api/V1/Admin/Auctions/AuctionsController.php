<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminAuctionStore;
use App\Model\Product\Product;
use Illuminate\Http\Request;
use App\Model\Store\Store;
use App\Model\Auction\Auction;

class AuctionsController extends AdminController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminAuctionStore $request)
    {

        $product = Product::updateOrCreate([
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

        $auction             = Auction::create([
            'store_id'      => Store::getCurrentStore()->id,
            'product_id'    => $product->id,
            'name'          => $request->input('auction.name'),
            'status'        => $request->input('auction.status'),
            'initial_price' => $request->input('auction.starting_price'),
            'min_bid'       => $request->input('auction.min_bid'),
            'is_buyout'     => $request->input('auction.is_buyout'),
            'buyout_price'  => $request->input('auction.buyout_price'),
            'start_date'    => $request->input('auction.start_date'),
            'end_date'      => $request->input('auction.end_date'),
        ]);

        return $auction;
        return $request->all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction $auctions)
    {
        return 'Auctions Edit';
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Auction\Auction  $auctions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auctions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Auction\Auction  $auctions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auctions)
    {
        //
    }

}
