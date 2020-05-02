<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Events\GenerateBidsEvent;
use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\MaxBidInvoke;
use App\Http\Resources\MaxBidsResource;
use App\Jobs\GenerateBids;
use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use App\Model\Store\Store;
use App\Model\Customer\Customer;
use App\Observers\MaxBidObserver;
use Illuminate\Support\Arr;


class MaxBidController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  MaxBidInvoke  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(MaxBidInvoke $request)
    {
        $validated = Arr::dot($request->validated());
        /**
         * Crate or update customer
         */
        $customer = $request->getCustomer();

        /**
         * Create or update customers max bid
         * Either generate a create or update log
         *
         * @see MaxBidObserver::created()
         * @see MaxBidObserver::updated()
         */
        $maxBid = MaxBid::updateOrCreate([
            ['store_id', Store::getCurrentStore()->id],
            ['auction_id', $validated['auction_id']],
            ['customer_id', $customer->id],
        ], [
            'store_id'    => Store::getCurrentStore()->id,
            'auction_id'  => $validated['auction_id'],
            'customer_id' => $customer->id,
            'amount'      => $validated['max_bid.amount'],
            'outbid'      => FALSE,
        ]);

        GenerateBids::dispatchNow($customer, $maxBid);

        return new MaxBidsResource($maxBid->load('auction'));
    }

}
