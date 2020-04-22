<?php

namespace App\Jobs\Auction;

use App\Model\Auction\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AuctionEnded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $auction;
    public $state;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
        $this->state   = $auction->state;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->auction->status == 'Disabled') {
            return $this;
        }

        if (!$this->has_ended) {
            return $this;
        }

        if ($this->auction->hammer_price) {
            return $this;
        }

        $this->auction->update([
            'hammer_price' => $this->auction->current_price,
        ]);

        if ($this->auction->leading_max_bid_id) {
            AuctionEndedEmail::dispatch($this->auction);
        }

        GenerateAuctionLog::dispatch($this->auction, 'Auction Ended');
    }
}
