<?php

namespace App\Http\Controllers\Api\V1\Admin\Notification;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Model\Notification\Notification;
use App\Model\Store\Store;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

/**
 * Class ViewController
 *
 * @package App\Http\Controllers\Api\V1\Admin\Notification
 *
 * TODO: Finish this with a resource and better submittions
 */
class ViewController extends AdminController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        return Store::getCurrentStore()->notifications()->findOrFail($id);

       // return new HtmlString($notification->body);
    }
}
