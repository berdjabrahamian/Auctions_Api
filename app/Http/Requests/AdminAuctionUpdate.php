<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Model\Auction\Auction;
use App\Model\Store\Store;

class AdminAuctionUpdate extends FormRequest
{
    protected $now;

    public function __construct()
    {
        parent::__construct();

        $this->now = Carbon::now();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $auction = $this->auction;

        if ($auction && $auction->store_id == Store::getCurrentStore()->id) {
                return true;
        }

        return false;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => ['sometimes'],
            'status'     => ['sometimes'],
            'end_date'   => ['sometimes'],
            'start_date' => ['sometimes'],
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function() {
            $this->_checkIfStarted();
            $this->_checkIfEnded();
        });
    }

    protected function _checkIfStarted() {
        if ($this->auction->hasStarted) {
            $this->validator->errors()->add('Auction Started',
                "The auction has already started");
            return $this;
        }
    }

    protected function _checkIfEnded() {
        if ($this->auction->hasEnded) {
            $this->validator->errors()->add('Auction Ended',
                "The auction has already ended");
            return $this;
        }
    }
}
