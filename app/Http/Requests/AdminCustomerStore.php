<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCustomerStore extends FormRequest
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
            'email'       => ['required', 'email', 'unique:customers,email'],
            'first_name'  => ['required', 'string'],
            'last_name'   => ['required', 'string'],
            'platform_id' => ['required', 'integer'],
            'approved'    => ['required', 'boolean'],
        ];
    }
}
