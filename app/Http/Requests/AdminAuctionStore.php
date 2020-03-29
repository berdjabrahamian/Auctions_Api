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

    protected $product;

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
            $this->_productChecks();
            $this->_auctionChecks();
        });
    }

    protected function _productChecks()
    {
        $product = Product::where([
            ['platform_id', $this->query('product')['platform_id']],
            ['store_id', Store::getCurrentStore()->id],
        ])->first();

        $this->setProduct($product);

        return $this;

    }


    /**
     * Run Checks against current store auctions as safegaurds
     *
     * Does product exists based on its product_id
     * Does auction exist based on its connected product
     * Is auction enabled
     * Is auction running
     *
     *
     *
     * Since an auction item is supposed to be unique, then each product connected to it needs to be unique as well.
     *
     */
    protected function _auctionChecks()
    {
        $now = Carbon::now();


        if ($this->product) {
            $auction = Auction::where([
                ['product_id', $this->product->id],
                ['store_id', Store::getCurrentStore()->id],
            ])->first();

            if (!$auction) {
                return $this;
            }

            if ($auction->status) {
                $this->validator->errors()->add('Is Auction',
                    "This product is already connected to an auction that is enabled - Auction Id {$auction->id}");
                if ($auction->end_date >= $now) {
                    $this->validator->errors()->add('Running Auction',
                        "This product is connected to an auction that is currently running - Auction Id {$auction->id}");
                }
            }

        }

        return $this;
    }

    public function prepareForValidation()
    {
        return $this;
    }

    /**
     * @param  mixed  $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }
}
