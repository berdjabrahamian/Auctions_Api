<?php

namespace App\Mail;

use App\Model\Auction\MaxBid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MaxBidUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $maxBid;
    public $auction;
    public $product;
    public $store;
    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MaxBid $maxBid)
    {
        $this->queue    = 'emails';
        $this->maxBid   = $maxBid;
        $this->auction  = $maxBid->auction;
        $this->store    = $maxBid->store;
        $this->customer = $maxBid->customer;
        $this->product  = $this->auction->product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->store->contact_email)
            ->to($this->customer->email)
            ->subject('Max Bid Updated')
            ->view('emails.maxbid.updated');
    }
}
