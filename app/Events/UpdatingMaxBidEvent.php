<?php

namespace App\Events;

use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatingMaxBidEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $maxBid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MaxBid $maxBid)
    {
        $this->maxBid = $maxBid;
    }
}
