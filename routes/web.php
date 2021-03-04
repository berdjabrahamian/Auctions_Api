<?php

use App\Jobs\LogCustomerNotification;
use App\Mail\MaxBidCreated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/belig', function () {
    $auction = \App\Model\Auction\Auction::all()->first();

    \App\Events\Auction\AuctionCreated::dispatch($auction);
    \App\Events\Auction\AuctionEnded::dispatch($auction);
});

Route::namespace('Frontend\V1')->group(function () {
    Route::resource('/auctions', 'Auctions\AuctionsController')->names(['index' => 'auctions.index']);
});
