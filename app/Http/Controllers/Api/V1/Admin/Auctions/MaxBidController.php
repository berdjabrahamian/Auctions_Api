<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Events\GenerateBidsEvent;
use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminMaxBidInvoke;
use App\Jobs\GenerateBids;
use App\Model\Auction\MaxBid;
use App\Model\Store\Store;
use App\Model\Customer\Customer;


class MaxBidController extends AdminController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(AdminMaxBidInvoke $request)
    {

        $customer = Customer::newOrUpdate($request->input('customer'));

//        $maxBid = MaxBid::newOrUpdate($request);

        //Check if customer already placed a bid then update it
        //If not create a new max bid
        $maxBid = MaxBid::updateOrCreate([
            ['store_id', Store::getCurrentStore()->id],
            ['auction_id', $request->input('auction_id')],
            ['customer_id', $customer->id],
        ], [
            'store_id'    => Store::getCurrentStore()->id,
            'auction_id'  => $request->input('auction_id'),
            'customer_id' => $customer->id,
            'amount'      => $request->input('max_bid.amount'),
        ]);

        GenerateBids::dispatchNow($customer, $maxBid);


      //Create the max bid

        //Check if outbid or not


        //Update the auction state

        //Add the necessary logs


        return $request->all();
    }

}
