<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Resources\AdminLogsCollection;
use App\Model\Auction\Auction;
use Illuminate\Http\Request;
use App\Model\Store\Store;

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
     * TODO: Finish this
     */
    public function show(Auction $auction)
    {
        return $auction->load(['logs']);
    }
}
