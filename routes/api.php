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


            Route::resource('auctions', 'AuctionsController')->only(['index', 'show']);
            Route::GET('auctions/logs', 'LogsController@index')->name('auctions.logs.index');
            Route::GET('{auction}/logs', 'LogsController@show')->name('auctions.logs.show');

//            Route::GET('auctions/{auction}/bid_history', 'BidHistoryController')
//                ->name('auctions.getBids');
//
//            Route::POST('auctions/max_bids', 'MaxBidsController')
//                ->name('auctions.createMaxBids');
        });
        Route::namespace('Admin')->group(function () {
            Route::prefix('admin')->group(function () {
                Route::namespace('Auctions')->group(function () {
                    Route::resource('auctions', 'AuctionsController')->except(['index', 'show']);
                });
                Route::namespace('Products')->group(function () {
                    Route::resource('products', 'ProductsController');
                });
            });
        });
    });
});

