<?php

namespace App\Rules;

use App\Model\Auction\Auction;
use Illuminate\Contracts\Validation\Rule;

class AuctionCreateTypeCheck implements Rule
{

    private $auctionTypes;


    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auctionTypes = Auction::AUCTION_TYPES;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (in_array($value, $this->auctionTypes)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Auction is of the wrong type.';
    }
}
