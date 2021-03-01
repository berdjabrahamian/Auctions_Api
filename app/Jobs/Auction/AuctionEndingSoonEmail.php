<?php

namespace App\Jobs\Auction;

use App\Jobs\LogCustomerNotification;
use App\Mail\EndingSoonNotification;
use App\Model\Auction\Auction;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use function Sentry\captureException as sentryException;
use function Sentry\captureMessage;

class AuctionEndingSoonEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $auction;
    public $customers;

    /**
     * Create a new job instance.
     *
     * @param  Auction  $auction
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
                Mail::send(new EndingSoonNotification($customer, $this->auction));
                LogCustomerNotification::dispatchAfterResponse(new EndingSoonNotification($customer, $this->auction));
            }
        }

        return $this;
    }

    /**
     * @param  Exception  $exception
     */
    public function failed($exception)
    {
        captureMessage('Auction Ending Soon Email Failed');
        sentryException($exception);
    }
}
