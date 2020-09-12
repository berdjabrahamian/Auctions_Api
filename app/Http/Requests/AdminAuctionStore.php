<?php

namespace App\Http\Requests;

use App\Model\Auction\Auction;
use App\Model\Product\Product;
use App\Model\Store\Store;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AdminAuctionStore
 *
 * @package App\Http\Requests
 */
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
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'auction.name'           => ['required'],
            'auction.status'         => ['required'],
            'auction.starting_price' => ['required', 'integer'],
            'auction.min_bid'        => ['required', 'integer'],
            'auction.is_buyout'      => ['present', 'boolean'],
            'auction.buyout_price'   => ['required', 'integer'],
            'auction.start_date'     => ['required', 'date'],
            'auction.end_date'       => ['required', 'date:after:start_date'],
            'auction.type'           => ['required'],
            'product.platform_id'    => ['required'],
            'product.sku'            => ['required'],
            'product.name'           => ['required'],
            'product.description'    => ['required'],
            'product.image_url'      => ['required'],
            'product.product_url'    => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function () {
            $this->_productChecks();
            $this->_auctionChecks();
        });
    }

    /**
     * CHECKS
     * Does product exists - if no product -> then no auction check -> then everything is new and needs to be created
     * Multiple Products same ID -> platform_id should be unique to each product (primary key from the platform) -> and
     * so there shouldn't be multiple products with the same primary key Sku match -> Sku from the request should match
     * sku already in system
     *
     * @return $this
     */
    protected function _productChecks()
    {
        //Get products that belong to the store and have the same sku
        $product = Store::getCurrentStore()->products()->where([
            ['platform_id', $this->query('product')['platform_id']],
        ])->get();


        if (!$product->count()) {
            $this->validator->errors()->add('Product Not Found',
                "Product doesnt exist in system, please create a product before assigning it to an auction");
            return $this;
        }

        if ($product->count() >= 1) {
            $this->validator->errors()->add('Multiple Products',
                "There are multiple products that have the same platform_id");

            return $this;
        }

        if ($product->first()->sku != $this->query('product')['sku']) {
            $this->validator->errors()->add('Existing Product',
                "A product with the ID of {$product->first()->platform_id} has a different sku that the one provided");

            return $this;
        }

        $this->setProduct($product->first());

        return $this;

    }


    /**
     * Run Checks against current store auctions as safe-guards
     *
     * Does product exists based on its product_id
     * Does auction exist based on its connected product
     * Is auction enabled
     * Is auction running
     *
     *
     * Since an auction item is supposed to be unique, then each product connected to it needs to be unique as well.
     *
     */
    protected function _auctionChecks()
    {
        if ($this->product) {
            $now = Carbon::now();

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

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }
}
