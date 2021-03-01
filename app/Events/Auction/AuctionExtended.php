<?php

namespace App\Events\Auction;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionExtended implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('auction-'.$this->auction->id);

//        return new PrivateChannel('channel-name');
    }


    public function broadcastWith()
    {
        return [
            'auction' => [
                'id'           => $this->auction->id,
                'name'         => $this->auction->name,
                'has_ended'    => $this->auction->has_ended,
                'hammer_price' => $this->auction->hammer_price,
                'bids_count'   => $this->auction->bids_count,
                'image'        => $this->auction->product->image_url,
            ],
            'message' => 'Auction Ended',
        ];
    }
}
