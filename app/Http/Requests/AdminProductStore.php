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
            'product_url' => ['required', 'url'],
        ];
    }
}
