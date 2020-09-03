<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Exceptions\GenerateNewMaxBidException;
use App\Model\Auction\MaxBid\GenerateMaxBid as GenerateMaxBid;
use App\Model\Auction\MaxBid\GenerateAbsoluteMaxBid as GenerateAbsoluteMaxBid;
use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\MaxBidInvoke;
use App\Http\Resources\MaxBidsResource;
use App\Model\Auction\MaxBid;
use App\Model\Store\Store;
use App\Observers\MaxBidObserver;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class MaxBidController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  MaxBidInvoke  $request
     *
     * @throws GenerateNewMaxBidException
     *
     * @return MaxBidsResource
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
        DB::beginTransaction();

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

        if ($maxBid->auction->type == 'absolute') {
            $generateBid = new GenerateAbsoluteMaxBid($customer, $maxBid);
        } else {
            $generateBid = new GenerateMaxBid($customer,$maxBid);
        }

        $generateBid->handle();

        DB::commit();

        return new MaxBidsResource($maxBid);
    }

}
