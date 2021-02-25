<?php
// TODO: finish this with additional logic
namespace App\Http\Requests;

use App\Model\Store\Store;
use Illuminate\Foundation\Http\FormRequest;

class AdminProductStore extends FormRequest
{
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
            'sku'         => ['required'],
            'platform_id' => ['required'],
            'name'        => ['required'],
            'description' => ['required'],
            'image_url'   => ['required', 'url'],
            'product_url' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function () {
//            $this->_productChecks();
        });
    }

    /**
     * Check to see if there is an existing products with the same sku, platform id, and store
     */
    protected function _productChecks()
    {
        // Product by Platform_ID & Store_ID
        $product = Store::getCurrentStore()->products()->where([
            ['sku', $this->input('sku')],
            ['platform_id', $this->input('platform_id')],
        ])->first();

        //This is good, a product should not exist since we are creating it from scratch
        if (!$product) {
            return $this;
        }

        //The rest of this is bad
        if ($product->count() >= 2) {
            $this->validator->errors()->add('Multiple Products',
                "There are multiple products that have the same platform_id");
            return $this;
        }

        if ($product->first()->sku == $this->query('sku')) {
            $this->validator->errors()->add('Existing Product',
                "A product with the same sku already exists, each product needs to have a unique platform_id and sku");

            return $this;
        }

        return $this;

    }
}
