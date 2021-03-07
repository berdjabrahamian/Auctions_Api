<?php

namespace App\Jobs;

use App\Model\Auction\MaxBid;
use App\Model\Notification\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogCustomerNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $maxBid;
    public $mailType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MaxBid $maxBid, $mailType)
    {
        $this->mailType = $mailType;
        $this->maxBid   = $maxBid;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = new Notification();

        $notification->type        = class_basename($this->mailType);
        $notification->store_id    = $this->maxBid->store->id;
        $notification->customer_id = $this->maxBid->customer->id;
        $notification->auction_id  = $this->maxBid->auction->id;
        $notification->max_bid     = $this->maxBid->id;


        $notification->save();

        GenerateAuctionLog::dispatchNow($this->mail->auction->id, "Notification: ",
            ['customer_id' => $this->maxBid->customer->id]);

    }
}
