<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Exceptions\GenerateNewMaxBidException;
use App\Model\Auction\MaxBid\GenerateMinBid;
use App\Model\Auction\MaxBid\GenerateAbsoluteBid;
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

        $maxBid = Store::getCurrentStore()->maxBids()->where([
            'auction_id'  => $validated['auction_id'],
            'customer_id' => $customer->id,
        ])->first();

        /**
         * Create or update customers max bid
         * Either generate a create or update log
         *
         * @see MaxBidObserver::created()
         * @see MaxBidObserver::updated()
         */
        DB::transaction(function () use ($validated, $customer, &$maxBid) {

            if (is_null($maxBid)) {
                $maxBid              = new MaxBid();
                $maxBid->store_id    = Store::getCurrentStore()->id;
                $maxBid->auction_id  = $validated['auction_id'];
                $maxBid->customer_id = $customer->id;
                $maxBid->amount      = $validated['max_bid.amount'];
                $maxBid->outbid      = FALSE;
            } else {
                $maxBid->update([
                    'amount' => $validated['max_bid.amount'],
                    'outbid' => FALSE,
                ]);
            }

            $maxBid->save();


            switch ($maxBid->auction->type) {
                case 'absolute':
                    (new GenerateAbsoluteBid($customer, $maxBid))->handle();
                    break;
                case 'min_bid':
                    (new GenerateMinBid($customer, $maxBid))->handle();
                    break;
                default:
                    (new GenerateMinBid($customer, $maxBid))->handle();
                    break;
            }

        });

        return new MaxBidsResource($maxBid);
    }

}
