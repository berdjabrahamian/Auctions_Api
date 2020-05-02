<?php

namespace App\Observers;

use App\Model\Auction\Auction;
use App\Model\Auction\State;

class StateObserver
{
    /**
     * Handle the state "updated" event.
     *
     * @param  \App\app\Model\Auction\State  $state
     *
     * @return void
     */
    public function updated(State $state)
    {
        if ($state->wasChanged('current_price')) {
            Auction::updateState($state);
        }
    }
}
