<?php

namespace App\Jobs\Auction;

use App\Mail\EndingSoonNotification;
use App\Model\Auction\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuctionEndingSoonEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries                   = 3;
    public $deleteWhenMissingModels = TRUE;
    public $auction;
    public $customers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction   = $auction->fresh();
        $this->customers = $this->auction->customers->unique();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ($this->auction->status == FALSE) {
            return $this;
        }


        foreach ($this->customers as $customer) {
            Mail::send(new EndingSoonNotification($customer, $this->auction));
        }
    }
}
