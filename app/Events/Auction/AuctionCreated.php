<?php

namespace App\Events\Auction;

use App\Model\Auction\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionCreated implements ShouldBroadcast
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
        return new Channel('auctions');

//        return new PrivateChannel('channel-name');
    }

    public function broadcastWith()
    {
        return [
            'auction' => [
                'id'            => $this->auction->id,
                'name'          => $this->auction->name,
                'status'        => $this->auction->status,
                'initial_price' => $this->auction->initial_price,
                'start_date'    => $this->auction->start_date,
                'end_date'      => $this->auction->end_date,
                'type'          => $this->auction->type,
                'image'         => $this->auction->product->image_url,
            ],
            'message' => 'Auction Created',
        ];
    }
}
