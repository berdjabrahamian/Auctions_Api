<?php

namespace App\Model\Notification;

use App\Model\Auction\Auction;
use App\Model\Customer\Customer;
use App\Model\Store\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;

class Notification extends Model
{
    protected $table = 'customer_notifications';


    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function create_and_save()
    {

        //dd($mailer->build()->subject);

        Notification::create([
            'type'         => get_class($mailer),
            'store_id'     => $mailer->store->id,
            'customer_id'  => $mailer->customer->id,
            'auction_id'   => $mailer->auction->id,
            'subject'      => $mailer->build()->subject,
            'body'         => $mailer->build()->render(),
            'to_address'   => $mailer->build()->to[0]['address'],
            'from_address' => $mailer->build()->from[0]['address'],
            'scheduled_at' => Carbon::now(),
            'sent'         => FALSE,
        ]);

    }
}
