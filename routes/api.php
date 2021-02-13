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
            Route::post('auctions/max-bids', 'MaxBidController')->name('auction.create.max_bid');
            Route::get('auctions/{id}/bids', 'BidHistoryController')->name('auction.bid_history');
            Route::resource('auctions', 'AuctionsController')->only(['index', 'show']);
        });

        Route::namespace('Customers')->group(function () {
            Route::get('customers/{customer}/auctions', 'AuctionsController')->name('customer.auctions');
        });

        Route::namespace('Admin')->name('admin.')->group(function () {
            Route::prefix('admin')->group(function () {
                Route::namespace('Auctions')->group(function () {
                    Route::get('auctions/logs', 'LogsController@index')->name('auctions.logs.index');
                    Route::get('auctions/{auction}/logs', 'LogsController@show')->name('auctions.logs.show');
                    Route::resource('auctions', 'AuctionsController')->only([
                        'index', 'store', 'show', 'update', 'destroy',
                    ]);
                });
                Route::namespace('Products')->group(function () {
                    Route::resource('products', 'ProductsController')->only([
                        'index', 'store', 'show', 'update', 'destroy',
                    ]);

                    Route::post('products/{product}/duplicate', 'DuplicateController')->name('product.duplicate');
                });
                Route::namespace('Customers')->group(function () {
                    Route::resource('customers', 'CustomersController')->only([
                        'index', 'store', 'show', 'update', 'destroy',
                    ]);
                });
                Route::namespace('Notification')->group(function() {
                    Route::get('notification/{id}', 'ViewController')->name('notification.view.email');
                });

                Route::namespace('Stores')->group(function() {
                   Route::get('store', 'StoresController')->name('store');

                   Route::resource('store/{store}/options', 'OptionsController')->only(['store', 'update']);
                });
            });
        });
    });
});


