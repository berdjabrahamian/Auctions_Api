<?php

namespace App\Jobs;

use App\Model\Auction\Auction;
use App\Model\Auction\Log;
use App\Model\Store\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log as LogAlias;

class GenerateAuctionLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $maxExceptions = 3;

    public $auction;
    public $activity;
    public $opts;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auction, string $activity, array $opts = NULL)
    {
        $this->queue = 'logs';
        $this->auction  = $auction;
        $this->activity = $activity;
        $this->opts     = collect($opts);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->auction instanceof Auction) {
            $this->auction = Auction::find($this->auction)->unsetRelations();
        }

        if ($this->auction->status == 'Disabled') {
            return $this;
        }

        $log             = new Log();
        $log->auction_id = $this->auction->id;
        $log->store_id   = $this->auction->store_id;
        $log->activity   = $this->activity;

        if ($this->opts->has('customer_id')) {
            $log->customer_id = $this->opts->get('customer_id');
        }
        if ($this->opts->has('amount')) {
            $log->amount = $this->opts->get('amount');
        }

        $log->save();

        return $this;
    }

    // TODO: Handle Failed Job
    public function failed($exception)
    {

    }
}
