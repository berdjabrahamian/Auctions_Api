<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\BidHistoryCollection;
use App\Model\Auction\Bid;
use Illuminate\Http\Request;

class BidHistoryController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $bids = Bid::where('auction_id', $id)->orderBy('id', 'desc')->with('customer')->get();
        return new BidHistoryCollection($bids->load('customer'));
    }
}
