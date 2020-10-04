<?php

namespace App\Listeners;

use App\Jobs\GenerateAuctionLog;
use App\Model\Notification\Notification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use function GuzzleHttp\Psr7\str;

class LogCustomerNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $messageHeaders = $event->message;

        $c = Notification::create([
            'store_id' => $event->data['store']->id,
            'customer_id' => $event->data['customer']->id,
            'auction_id' => $event->data['auction']->id,
            'subject' => $messageHeaders->getSubject(),
            'body' => $messageHeaders->getBody(),
            'to_address' => (string)json_encode($messageHeaders->getTo()),
            'from_address' => (string)json_encode($messageHeaders->getFrom()),
            'scheduled_at' => $messageHeaders->getDate()->format(Carbon::ISO8601),
        ]);

        $c->save();

        GenerateAuctionLog::dispatchNow($event->data['auction'], "Notification Sent: {$messageHeaders->getSubject()}", ['customer_id'=>$event->data['customer']->id]);
    }
}
