<?php

namespace App\Http\Requests;

use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use App\Model\Customer\Customer;
use App\Model\Store\Store;
use Illuminate\Foundation\Http\FormRequest;

class MaxBidInvoke extends FormRequest
{

    protected $customer;
    protected $maxBid;
    protected $auction;
    protected $maxBidRequestAmount;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $auction = Auction::where([
            ['id', $this->input('auction_id')],
            ['store_id', Store::getCurrentStore()->id],
        ])->first();

        $this->setAuction($auction);

        if ($auction && $auction->status == 'Enabled') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'auction_id'     => 'required|numeric|exists:auctions,id',
            'max_bid.amount' => 'required|gt:0|numeric',
            'customer.id'    => 'required',
            'customer.email' => 'required|email',
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
        $customer = Customer::where([
            'platform_id' => $this->input('customer.id'),
            'store_id'    => Store::getCurrentStore()->id,
            'email'       => $this->input('customer.email'),
        ])->first();

        if (!$customer) {
            $this->validator->errors()->add('Customer Not Found',
                "Customer account doesnt exist in system, please create the customer");

            return $this;
        }

        if (!$customer->approved) {
            $this->validator->errors()->add('Customer Not Approved',
                "Customer account hasnt been approved for bidding");

            return $this;
        }

        $this->setCustomer($customer);

        return $this;
    }


    private function _auctionChecks()
    {
        $auction = $this->getAuction();

        if (!$auction->has_started) {
            $this->validator->errors()->add('Auction Hasnt Started',
                "Auction hasn't started yet, cant place bid.");

            return $this;
        }

        if ($auction->has_ended) {
            $this->validator->errors()->add('Auction Ended',
                "Auction has ended and not accepting any more bids");

            return $this;
        };

        if ($this->maxBidRequestAmount <= $auction->current_price) {
            $this->validator->errors()->add('Max Bid Amount',
                "Max Bid amount cant be less than or equal to the current auction price");

            return $this;
        }

        return $this;

    }

    /**
     *
     * @return $this
     */
    private function _maxBidChecks()
    {
        $customer = $this->getCustomer();

        if ($customer) {
            $maxBid = MaxBid::where([
                'store_id'    => Store::getCurrentStore()->id,
                'auction_id'  => $this->input('auction_id'),
                'customer_id' => $this->customer->id,
            ])->first();

            $this->setMaxBid($maxBid);
        }

        if (!$this->maxBid) {
            return $this;
        }

        if ($this->maxBidRequestAmount == $this->maxBid->amount) {
            $this->validator->errors()->add('Max Bid',
                "Already set to {$this->maxBidRequestAmount}");
        }

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


}
