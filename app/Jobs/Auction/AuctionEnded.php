<?php

namespace App\Jobs\Auction;

use App\Jobs\GenerateAuctionLog;
use App\Model\Auction\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AuctionEnded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries         = 1;
    public $maxExceptions = 1;
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

        if (!$this->auction->hasEnded()) {
            return $this;
        }

        $this->auction->update([
            'hammer_price' => $this->auction->current_price,
        ]);

        AuctionEndedEmail::dispatch($this->auction);
        GenerateAuctionLog::dispatch($this->auction, 'Auction Ended');
    }
}
