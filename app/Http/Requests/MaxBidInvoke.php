<?php

namespace App\Http\Requests;
use App\Model\Auction\MaxBid;
use App\Model\Store\Store;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MaxBidInvoke
 *
 * @package App\Http\Requests
 */
class MaxBidInvoke extends FormRequest
{

    /**
     * @var
     */
    protected $customer;
    protected $maxBid;
    protected $auction;
    protected $store;


    /**
     * @var
     */
    protected $maxBidRequestAmount;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $auction = Store::getCurrentStore()->auctions()->where([
            ['id', $this->input('auction_id')]
        ])->first();

        if ($auction && $auction->status == 'enabled') {
            $this->setAuction($auction);
            $this->setStore($auction->store);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     *
     * @return array
     */
    public function rules()
    {
        return [
            'auction_id'     => ['required', 'numeric', 'exists:auctions,id'],
            'max_bid.amount' => ['required', 'gt:0', 'numeric'],
            'customer.id'    => ['required', 'numeric'],
            'customer.email' => ['required', 'email'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'auction_id' => (int) $this->input('auction_id'),
            'max_bid'    => [
                'amount' => (int) $this->input('max_bid.amount'),
            ],
            'customer'   => [
                'id'    => (int) $this->input('customer.id'),
                'email' => (string) $this->input('customer.email'),
            ],
        ]);

        $this->setMaxBidRequestAmount($this->input('max_bid.amount'));
    }

    public function withValidator($validator)
    {
        $validator->after(function () {
            $this->_customerChecks();
            $this->_auctionChecks();
            $this->_maxBidChecks();
        });
    }

    /**
     *
     */
    private function _customerChecks()
    {
        $customer = Store::getCurrentStore()->customers()->where([
            'platform_id' => $this->input('customer.id'),
            'email'       => $this->input('customer.email'),
        ])->first();

        if (!$customer) {
            $this->validator->errors()->add('Customer Not Found',
                "Customer account doesnt exist in system, please create the customer");

            return $this;
        }

        if (!$customer->approved) {
            $this->validator->errors()->add('Customer Not Approved',
                "Customer account hasn't been approved for bidding");

            return $this;
        }

        $this->setCustomer($customer);

        return $this;
    }


    /**
     * @throws Illuminate\Support\MessageBag Auction hasn't started and not accepting any bids
     * @throws Illuminate\Support\MessageBag Auction has ended and not accepting any more bids
     *
     * @return $this
     */
    private function _auctionChecks()
    {
        if (!$this->getAuction()->has_started) {
            $this->validator->errors()->add("Auction Hasn't Started",
                "Auction hasn't started and not accepting any bids");

            return $this;
        }

        if ($this->getAuction()->has_ended) {
            $this->validator->errors()->add('Auction Ended',
                "Auction has ended and not accepting any more bids");

            return $this;
        }

        return $this;

    }

    /**
     * @throws Illuminate\Support\MessageBag Already Set to {Max Bid Amount}
     * @throws Illuminate\Support\MessageBag Max Bid Amount cant be less than or equal to the current auction price
     *
     * @return $this
     */
    private function _maxBidChecks()
    {
        // Dont allow setting a bid that is lower than the current auction price
        if ($this->maxBidRequestAmount <= $this->auction->current_price) {
            $this->validator->errors()->add('Max Bid Amount',
                "Max Bid amount cant be less than or equal to the current auction price");

            return $this;
        }

        // Bid cant be less than the Auction Current Price + Min Bid
        if (($this->getAuction()->current_price + $this->getAuction()->min_bid) > $this->maxBidRequestAmount) {
            $this->validator->errors()->add('Max Bid Amount',
                "The bid you placed is less than the allowed minimum bid for this auction");
            return $this;
        }


        $maxBid = Store::getCurrentStore()->maxBids()->where([
            'auction_id'  => $this->input('auction_id'),
            'customer_id' => $this->customer->id,
        ])->first();


        if (is_null($maxBid)) {
            return $this;
        }

        $this->setMaxBid($maxBid);


        // Dont allow setting a bid that is the same as the customers already existing max bid
        if ($this->maxBidRequestAmount == $this->maxBid->amount) {
            $this->validator->errors()->add('Max Bid',
                "Already set to {$this->maxBidRequestAmount}");
        }

        // SPECIFIC AUCTION CHECKS
        switch ($this->auction->type){
            case 'absolute':
                $this->_absoluteAuctionChecks();
                break;
            case 'min_bid':
                $this->_minBidAuctionChecks();
                break;
            default:
                return $this;
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function _absoluteAuctionChecks() {

        //Bidding more than the allowed amount
        $allowedMaxBidAmount = $this->getStore()->options->absolute_auction_max_bid_amount;

        if (($this->maxBidRequestAmount - $this->getAuction()->current_price) > $allowedMaxBidAmount) {
            $this->validator->errors()->add('Bid Amount',
                "You bid cant be more than \${$allowedMaxBidAmount} of the current auction price");
            return $this;
        }

        //Cant bid the same amount
        if ($this->maxBidRequestAmount == $this->getAuction()->current_price) {
            $this->validator->errors()->add('Bid Amount',
                "Your bid cant be the same as the current auction price");
            return $this;
        }

        //Customer cant outbid themselves if they are the winner
        if ($this->getAuction()->state->leading_id == $this->getMaxBid()->id) {
            $this->validator->errors()->add('Bid Amount',
                "You cant outbid yourself as the winner");
            return $this;
        }

        return $this;
    }

    private function _minBidAuctionChecks() {

        return $this;
    }

    /**
     * @param  mixed  $customer
     */
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @param  mixed  $maxBidRequestAmount
     */
    public function setMaxBidRequestAmount($maxBidRequestAmount): void
    {
        $this->maxBidRequestAmount = $maxBidRequestAmount;
    }

    /**
     * @param  mixed  $maxBid
     */
    public function setMaxBid($maxBid): void
    {
        $this->maxBid = $maxBid;
    }

    /**
     * @param  mixed  $auction
     */
    public function setAuction($auction): void
    {
        $this->auction = $auction;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return mixed
     */
    public function getMaxBid()
    {
        return $this->maxBid;
    }

    /**
     * @return mixed
     */
    public function getAuction()
    {
        return $this->auction;
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param  mixed  $store
     */
    public function setStore($store): void
    {
        $this->store = $store;
    }


}
