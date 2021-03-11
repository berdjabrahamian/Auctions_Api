<?php

namespace App\Http\Controllers\Frontend\V1\Auctions;

use App\Http\Controllers\Controller;
use App\Http\Resources\BidHistoryCollection;
use App\Model\Auction\Bid;
use Illuminate\Http\Request;

class BidsController extends Controller
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

        //TODO: turn this into a resource to return the names with values hidden
        $bids = Bid::where('auction_id', $id)->orderBy('id', 'desc')->with('customer')->get();
        return $bids;
        return view('v1.auctions.bids', ['bids' => new $bids]);

    }
}
