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
            'name'        => ['sometimes', 'string'],
            'description' => ['sometimes', 'required', 'string'],
            'image_url'   => ['sometimes', 'url'],
        ];
    }
}
