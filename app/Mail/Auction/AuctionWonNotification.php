<?php

namespace App\Mail\Auction;

use App\Model\Auction\Auction;
use App\Model\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWonNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $winner;
    public $auction;
    public $store;
    public $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $winner, Auction $auction)
    {
        $this->queue   = 'emails';
        $this->winner  = $winner;
        $this->auction = $auction;
        $this->store   = $this->auction->store;
        $this->product = $this->auction->product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->store->contact_email)
            ->to($this->winner->email)
            ->subject('Congratulations You Won')
            ->view('emails.auction.won');
    }
}
