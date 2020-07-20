<?php

namespace App\Observers;

use App\app\Model\Store\Store;
use App\Events\Store\StoreCreated;

class StoreObserver
{
    /**
     * Handle the store "created" event.
     *
     * @param  \App\app\Model\Store\Store  $store
     * @return void
     */
    public function created(Store $store)
    {
        StoreCreated::dispatch($store);
    }

    /**
     * Handle the store "updated" event.
     *
     * @param  \App\app\Model\Store\Store  $store
     * @return void
     */
    public function updated(Store $store)
    {
        //
    }

    /**
     * Handle the store "deleted" event.
     *
     * @param  \App\app\Model\Store\Store  $store
     * @return void
     */
    public function deleted(Store $store)
    {
        //
    }

    /**
     * Handle the store "restored" event.
     *
     * @param  \App\app\Model\Store\Store  $store
     * @return void
     */
    public function restored(Store $store)
    {
        //
    }

    /**
     * Handle the store "force deleted" event.
     *
     * @param  \App\app\Model\Store\Store  $store
     * @return void
     */
    public function forceDeleted(Store $store)
    {
        //
    }
}
