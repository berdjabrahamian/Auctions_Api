<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuctionIndex extends FormRequest
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
            'customer_id' => ['sometimes', 'integer'],
            'auction_ids' => ['sometimes', 'exclude_if:product_ids,true'],
            'product_ids' => ['sometimes', 'exclude_if:auction_ids,true'],
        ];
    }
}
