<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Resources\AdminAuctionShowResource;
use App\Http\Resources\AdminLogsCollection;
use App\Http\Resources\AdminLogsResource;
use App\Http\Resources\AdminLogsShowResource;
use App\Model\Auction\Auction;
use Illuminate\Http\Request;
use App\Model\Store\Store;
use Illuminate\Support\Collection;
use MongoDB\Driver\Query;

class LogsController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Store::getCurrentStore()->logs();

        return new AdminLogsCollection($logs->paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Auction\Log  $logs
     *
     * @return \Illuminate\Http\Response
     *
     *
     * TODO: Finish this
     */
    public function show($auction)
    {

        $logs = Store::getCurrentStore()->auctions()->where(['auctions.id' => $auction])->first()->load(['logs.customer']);

        return new AdminLogsShowResource($logs);

    }
}
