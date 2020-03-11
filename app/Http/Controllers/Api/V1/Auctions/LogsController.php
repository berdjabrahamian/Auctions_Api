<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Model\Auction\Log;
use App\Model\Auction\Auction;
use Illuminate\Http\Request;

class LogsController extends BaseController
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
