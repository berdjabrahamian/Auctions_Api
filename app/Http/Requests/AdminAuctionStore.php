<?php

namespace App\Http\Requests;

use App\Model\Auction\Auction;
use App\Model\Product\Product;
use App\Model\Store\Store;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AdminAuctionStore extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [
            'auction.name'           => 'required',
            'auction.status'         => 'required',
            'auction.starting_price' => 'required|integer',
            'auction.min_bid'        => 'required|integer',
            'auction.is_buyout'      => 'present|boolean',
            'auction.buyout_price'   => 'required|integer',
            'auction.start_date'     => 'required|date',
            'auction.end_date'       => 'required|date:after:start_date',
            'product.platform_id'    => 'required',
            'product.sku'            => 'required',
            'product.name'           => 'required',
            'product.description'    => 'required',
            'product.image_url'      => 'required',
            'product.product_url'    => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function () {
            $this->_alreadyRunningAuction();
        });
    }


    /**
     * Check if there are any running auctions that is connected to the product with the same product id
     * This is a safegaurd from creating multiple auctions on the same product at the same time
     *
     * Since an auction item is supposed to be unique, then each product connected to it needs to be unique as well.
     *
     */
    protected function _alreadyRunningAuction()
    {
        $now = Carbon::now();

        $product = Product::where([
            ['platform_id', $this->query('product')['platform_id']],
            ['store_id', Store::getCurrentStore()->id],
        ])->first();

        if (!$product) {
            return false;
        }

        $auction = Auction::where([
            ['product_id', $product->id],
            ['store_id', Store::getCurrentStore()->id],
        ])->first();



        if ($auction) {
            if ($auction->end_date <= $now) {
                $this->validator->errors()->add('Running Auction', "This product is already in a currently running auction - {$auction->id}");
            }
        }

        return false;

    }

    public function prepareForValidation()
    {
        return $this;
    }
}
