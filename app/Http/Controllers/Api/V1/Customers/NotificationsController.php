<?php

namespace App\Http\Controllers\Api\V1\Customers;

use App\Http\Controllers\Controller;
use App\Model\Store\Store;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
   public function __invoke() {
       return Store::getCurrentStore()->customers();
   }
}
