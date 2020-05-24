<?php

namespace App\Http\Controllers\Api\V1\Customers;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Resources\CustomersAuctionsResource;
use App\Model\Auction\MaxBid;
use App\Model\Customer\Customer;
use App\Model\Store\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AuctionsController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $customer = Store::getCurrentStore()->customers()->where('platform_id', $request->customer)->firstOrFail();

        $auctionsBidOn = $customer->auctionsBidOn()->with('product')
            ->addSelect('max_bids.outbid')
            ->addSelect('max_bids.amount as max_bid_amount')
            ->get();

        $customer = $customer->setRelation('auctions', $auctionsBidOn);

        return new CustomersAuctionsResource($customer);

    }
}
