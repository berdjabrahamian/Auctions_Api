<?php

namespace App\Http\Requests;

use App\Model\Auction\Auction;
use App\Model\Store\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AdminMaxBidInvoke extends FormRequest
{
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

        if ($auction) {
            return true;
        } else {
            return false;
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
            'auction_id'          => 'required|numeric',
            'max_bid.amount'      => 'required|numeric|',
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
    }


    public function withValidator($validator)
    {
        $validator->after(function () {
            $this->_maxBidChecks();
        });
    }


    /**
     * We check if the customer already placed a max bid on the account
     * @return $this
     */
    private function _maxBidChecks()
    {
        return $this;
    }


}
