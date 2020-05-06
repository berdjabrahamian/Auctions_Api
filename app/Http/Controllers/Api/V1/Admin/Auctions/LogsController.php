<?php

namespace App\Http\Controllers\Api\V1\Admin\Auctions;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Resources\AdminLogsCollection;
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
        $logs = Log::with(['customer', 'auction']);

        return new AdminLogsCollection($logs->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Auction\Log  $logs
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
    {
        return $auction->logs;
    }
}
