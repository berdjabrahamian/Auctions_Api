<?php

namespace App\Events\MaxBid;

use App\Model\Auction\MaxBid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class Created
 *
 * @package App\Events\MaxBid
 *
 * @see MaxBid;
 * The Max Bid will give you access to the following Models through eager loading
 *
 */
class Created
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

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
