<?php

namespace App\View\Components\Auction\Status;

use App\Model\Auction\Auction;
use Illuminate\View\Component;

class Started extends Component
{

    public $auction;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.auction.status.started');
    }
}
