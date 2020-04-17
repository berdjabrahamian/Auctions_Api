<?php

namespace App\Observers;

use App\Model\Auction\Auction;
use App\Model\Auction\State;

class StateObserver
{
    /**
     * Handle the state "created" event.
     *
     * @param  \App\app\Model\Auction\State  $state
     *
     * @return void
     */
    public function created(State $state)
    {
        //
    }

    /**
     * Handle the state "updated" event.
     *
     * @param  \App\app\Model\Auction\State  $state
     *
     * @return void
     */
    public function updated(State $state)
    {
        if ($state->wasChanged('amount'))
        Auction::updateState($state);
    }

    /**
     * Handle the state "deleted" event.
     *
     * @param  \App\app\Model\Auction\State  $state
     *
     * @return void
     */
    public function deleted(State $state)
    {
        //
    }

    /**
     * Handle the state "restored" event.
     *
     * @param  \App\app\Model\Auction\State  $state
     *
     * @return void
     */
    public function restored(State $state)
    {
        //
    }

    /**
     * Handle the state "force deleted" event.
     *
     * @param  \App\app\Model\Auction\State  $state
     *
     * @return void
     */
    public function forceDeleted(State $state)
    {
        //
    }
}
