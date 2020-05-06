<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAuctionUpdate extends FormRequest
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
            'name'       => 'sometimes',
            'status'     => 'sometimes',
            'end_date'   => 'sometimes',
            'start_date' => 'sometimes',
        ];
    }
}
