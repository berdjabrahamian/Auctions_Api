<?php

namespace App\Http\Controllers\Api\V1\Auctions;

use App\Http\Controllers\Api\V1\BaseController;
use App\Model\Auction\Auctions;
use Illuminate\Http\Request;

class AuctionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auctions::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'Auctions Create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Auction\Auctions $auctions
     * @return \Illuminate\Http\Response
     */
    public function show(Auctions $auction)
    {
        return $auction;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Auction\Auctions $auctions
     * @return \Illuminate\Http\Response
     */
    public function edit(Auctions $auctions)
    {
        return 'Auctions Edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Auction\Auctions $auctions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auctions $auctions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Auction\Auctions $auctions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auctions $auctions)
    {
        //
    }
}
