<?php

namespace App\Jobs;

use App\Mail\MaxBidCreated;
use App\Model\Auction\MaxBid;
use App\Model\Notification\Notification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mockery\Matcher\Not;

class LogCustomerNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailable $email)
    {
        $this->queue = 'logs';
        $this->mail = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = new Notification();

        $notification->store_id     = $this->mail->store->id;
        $notification->customer_id  = $this->mail->customer->id;
        $notification->auction_id   = $this->mail->auction->id;
        $notification->subject      = $this->mail->build()->subject;
        $notification->body         = $this->mail->render();
        $notification->to_address   = (string) json_encode($this->mail->build()->to);
        $notification->from_address = (string) json_encode($this->mail->build()->from);

        $notification->save();

        GenerateAuctionLog::dispatchNow($this->mail->auction->id, "Notification Sent: {$this->mail->build()->subject}",
            ['customer_id' => $this->mail->customer->id]);

    }
}
