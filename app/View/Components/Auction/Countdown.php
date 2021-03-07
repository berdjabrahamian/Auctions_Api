<?php

namespace App\View\Components\Auction;

use Illuminate\View\Component;

class Countdown extends Component
{
    public $endDate;
    public $startDate;
    public $timestamp;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($endDate, $startDate, $timestamp)
    {
        $this->endDate = $endDate;
        $this->startDate = $startDate;
        $this->timestamp = $timestamp;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.auction.countdown');
    }
}
