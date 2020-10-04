<?php

namespace App\Mail\Auction;

use App\Model\Auction\Auction;
use App\Model\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionExtendedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $auction;
    public $store;
    public $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, Auction $auction)
    {
        $this->queue    = 'emails';
        $this->auction  = $auction;
        $this->store    = $this->auction->store;
        $this->product  = $this->auction->product;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->store->contact_email, $this->store->name)
            ->to($this->customer->email, $this->customer->full_name)
            ->subject('Auction Extended')
            ->view('emails.auction.extended');
    }
}
