<?php

namespace App\Listeners;

use App\Events\MaxBid\Created;
use App\Events\MaxBid\Outbid;
use App\Events\MaxBid\Updated;
use App\Listeners\MaxBid\CreatedEmail;
use App\Listeners\MaxBid\OutbidEmail;
use App\Listeners\MaxBid\UpdatedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MaxBidSubscriber implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'listeners';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function subscribe($events)
    {
        $events->listen(
            Created::class,
            CreatedEmail::class
        );

        $events->listen(
            Updated::class,
            UpdatedEmail::class
        );

        $events->listen(
            Outbid::class,
            OutbidEmail::class
        );
    }
}
