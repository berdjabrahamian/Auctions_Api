<?php

namespace App\Http\Requests;

use App\Model\Product\Product;
use App\Model\Store\Store;
use Illuminate\Foundation\Http\FormRequest;

class AdminProductUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $product = Product::where([
            ['id', $this->product],
            ['store_id', Store::getCurrentStore()->id],
        ])->first();

        if (!$product) {
            return FALSE;
        } else {
            return TRUE;
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
            'name'        => 'present|string',
            'description' => 'present|string',
            'image_url'   => 'present|url',
            'product_url' => 'present|url',
        ];
    }
}
