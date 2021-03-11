<?php

namespace App\View\Components\Auction;

use App\Model\Auction\Auction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Card extends Component
{

    public $auction;
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
        $this->url     = $auction->slug;


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.auction.card', [
            'button_text' => $this->getButtonText(),

        ]);
    }

    public function getButtonText()
    {
        if (!$this->auction->hasStarted() || $this->auction->hasEnded()) {
            return 'View';
        } else {
            return 'View & Bid';
        }
    }
}
