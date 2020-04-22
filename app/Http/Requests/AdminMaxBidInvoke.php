<?php

namespace App\Http\Requests;

use App\Model\Auction\Auction;
use App\Model\Auction\MaxBid;
use App\Model\Customer\Customer;
use App\Model\Store\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AdminMaxBidInvoke extends FormRequest
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
        $auction = Auction::without(['product', 'logs'])->where([
            ['id', $this->input('auction_id')],
            ['store_id', Store::getCurrentStore()->id],
        ])->first();

        if ($auction && $auction->status == TRUE) {
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
            'auction_id'          => 'required|numeric|exists:auctions,id',
            'max_bid.amount'      => 'required|numeric',
            'customer.id'         => 'required',
            'customer.first_name' => 'required|string',
            'customer.last_name'  => 'required|string',
            'customer.email'      => 'required|email',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'auction_id' => (int) $this->auction_id,
            'max_bid'    => [
                'amount' => (int) $this->input('max_bid.amount'),
            ],
            'customer'   => [
                'id'         => $this->input('customer.id'),
                'first_name' => (string) $this->input('customer.first_name'),
                'last_name'  => (string) $this->input('customer.last_name'),
                'email'      => (string) $this->input('customer.email'),
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
            'platform_id' => $this->query('customer')['id'],
            'store_id'    => Store::getCurrentStore()->id,
            'email'       => $this->query('customer')['email'],
        ])->first();

        $this->setCustomer($customer);

        return $this;
    }


    private function _auctionChecks()
    {
        $auction = Auction::where([
            'store_id' => Store::getCurrentStore()->id,
            'id'       => $this->input('auction_id'),
        ])->first();

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
        if ($this->customer) {
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


}
