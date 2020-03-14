<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Controllers\Controller;
use App\Model\Auction\Auction;
use Illuminate\Http\Request;

class BidHistoryController extends BaseController
{
    // TODO: Finish this to only load only the auctions bid history
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Auction $auction)
    {
        return $auction;
    }
}
