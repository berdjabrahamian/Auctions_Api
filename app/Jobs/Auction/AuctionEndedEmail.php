<?php

namespace App\Jobs\Auction;

use App\Mail\Auction\AuctionGotAwayNotification;
use App\Mail\Auction\AuctionWonNotification;
use App\Model\Auction\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuctionEndedEmail implements ShouldQueue
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
        $this->auction   = $auction;
        $this->customers = $this->auction->customers->unique('id');
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

        if ($this->auction->hasWinner()) {
            $winner       = $this->auction->state->customer;
            $participants = $this->customers->except($winner->id);

            Mail::send(new AuctionWonNotification($winner, $this->auction));

            foreach ($participants as $participant) {
                Mail::send(new AuctionGotAwayNotification($participant, $this->auction));
            }
        }

        return $this;
    }

    // TODO: Handle Failed Job
    public function failed($exception)
    {

    }
}
