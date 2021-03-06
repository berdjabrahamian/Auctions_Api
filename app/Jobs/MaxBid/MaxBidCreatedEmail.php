<?php

namespace App\Jobs\MaxBid;

use App\Mail\MaxBidCreated;
use App\Model\Auction\MaxBid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MaxBidCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $maxBid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MaxBid $maxBid)
    {
        $this->maxBid = $maxBid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new MaxBidCreated($this->maxBid));
    }

    // TODO: Handle Failed Job
    public function failed($exception)
    {

    }
}
