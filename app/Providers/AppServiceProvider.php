<?php

namespace App\Providers;

use App\Model\Auction\Auction;
use App\Observers\AuctionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auction::observe(AuctionObserver::class);
    }
}
