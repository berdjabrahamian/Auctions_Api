<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Model\Auction\Log;
use App\Model\Auction\Auction;
use Illuminate\Http\Request;

class LogsController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Log::all();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Auction\Log $logs
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
    {
        return $auction->logs;
    }
}
