<?php

namespace App\Http\Requests;

use App\Model\Product\Product;
use App\Model\Store\Store;
use Illuminate\Foundation\Http\FormRequest;

class AdminProductDuplicate extends FormRequest
{

    public $product;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $product = Product::where([
            ['id', $this->id],
            ['store_id', Store::getCurrentStore()->id],
        ])->first();

        if ($product) {
            $this->setProduct($product);
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku'         => 'required|unique:products,sku',
            'name'        => 'required',
            'description' => 'required',
            'image_url'   => 'required|url',
            'product_url' => 'required|url',
            'platform_id' => 'sometimes',
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->input('platform_id')) {
            $this->merge([
                'platform_id' => base_convert(md5(serialize([$this->get('sku'), $this->get('name')])), 12, 10),
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param  mixed  $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }
}
