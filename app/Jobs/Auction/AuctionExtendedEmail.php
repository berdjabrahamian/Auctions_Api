<?php

namespace App\Jobs\Auction;

use App\Jobs\LogCustomerNotification;
use App\Mail\Auction\AuctionExtendedNotification;
use App\Model\Auction\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AuctionExtendedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $auction;
    public $customers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction   = $auction->load('customers');
        $this->customers = $auction->customers->unique('id');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->auction->status == 'disabled') {
            return $this;
        }

        if ($this->customers) {
            foreach ($this->customers as $customer) {
                Mail::send(new AuctionExtendedNotification($customer, $this->auction));
                LogCustomerNotification::dispatchAfterResponse(new AuctionExtendedNotification($customer, $this->auction));
            }
        }

        return $this;
    }
}
