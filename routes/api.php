<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::namespace('Api\V1')->group(function () {
        Route::namespace('Auctions')->group(function () {
            Route::resource('auctions', 'AuctionsController');

//            Route::GET('auctions/{auction}/bid_history', 'BidHistoryController')
//                ->name('auctions.getBids');
//
//            Route::POST('auctions/max_bids', 'MaxBidsController')
//                ->name('auctions.createMaxBids');
        });
//        Route::namespace('Admin')->group(function () {
//            Route::prefix('admin')->group(function () {
//                Route::namespace('Auctions')->group(function () {
//                    Route::apiResource('auctions', 'AuctionsController');
//                });
//            });
//        });
    });
});

