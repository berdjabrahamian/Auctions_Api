<?php

namespace App\Providers;

use App\Model\Auction\Auction;
use App\Model\Auction\Bid;
use App\Model\Auction\MaxBid;
use App\Model\Auction\State;
use App\Observers\AuctionObserver;
use App\Observers\BidObserver;
use App\Observers\MaxBidObserver;
use App\Observers\StateObserver;
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
        MaxBid::observe(MaxBidObserver::class);
        State::observe(StateObserver::class);
        Bid::observe(BidObserver::class);
    }
}
