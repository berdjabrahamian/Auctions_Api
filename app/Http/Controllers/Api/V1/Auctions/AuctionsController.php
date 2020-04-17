<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Resources\AuctionCollection;
use App\Model\Auction\Auction;
use App\Model\Store\Store;
use Illuminate\Http\Request;

class AuctionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auctions = Auction::byStore()->setEagerLoads([]);
//        if ($request->has('customer_id')){
        $auctions->withCustomerMaxBid($request->get('customer_id'));
//        }
//        $auctions->join('max_bids', function ($join) use ($request) {
//            $join->on('auctions.id', '=', 'max_bids.auction_id')
//            ->where('max_bids.customer_id', '=', $request->input('customer_id'));
//        });
//        $auctions->where('auctions.store_id', '=', Store::getCurrentStore()->id);

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
    public function show($id)
    {
        $auction = Auction::where([
            ['id', $id],
            ['store_id', Store::getCurrentStore()->id],
        ])->firstOrFail();


        return $auction;
    }
}
