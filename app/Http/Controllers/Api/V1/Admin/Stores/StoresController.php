<?php

namespace App\Http\Controllers\Api\V1\Admin\Stores;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Model\Store\Store;
use Illuminate\Http\Request;

class StoresController extends AdminController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Store::getCurrentStore()->with(['options'])->get();
    }
}
