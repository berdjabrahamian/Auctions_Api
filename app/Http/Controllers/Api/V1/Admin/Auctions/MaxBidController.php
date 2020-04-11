<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Events\GenerateBidsEvent;
use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminMaxBidInvoke;
use App\Jobs\GenerateBids;
use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use App\Model\Store\Store;
use App\Model\Customer\Customer;
use App\Observers\MaxBidObserver;


class MaxBidController extends AdminController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AdminMaxBidInvoke $request)
    {

        /**
         * Crate or update customer
         */
        $customer = Customer::updateOrCreate(
            [
                ['platform_id', $request->input('customer.id')],
                ['store_id', Store::getCurrentStore()->id],
            ],
            [
                'first_name' => $request->input('customer.first_name'),
                'last_name'  => $request->input('customer.last_name'),
                'email'      => $request->input('customer.email'),
            ]);

        $customer->platform_id = $request->input('customer.id');
        $customer->store()->associate(Store::getCurrentStore());
        $customer->save();


        /**
         * Create or update customers max bid
         * Either generate a create or update log
         *
         * @see MaxBidObserver::created()
         * @see MaxBidObserver::updated()
         */
        $maxBid = MaxBid::updateOrCreate([
            ['store_id', Store::getCurrentStore()->id],
            ['auction_id', $request->input('auction_id')],
            ['customer_id', $customer->id],
        ], [
            'store_id'    => Store::getCurrentStore()->id,
            'auction_id'  => $request->input('auction_id'),
            'customer_id' => $customer->id,
            'amount'      => $request->input('max_bid.amount'),
            'outbid'      => FALSE,
        ]);

        GenerateBids::dispatchNow($customer, $maxBid);

        return $maxBid->unsetRelations();
    }

}
