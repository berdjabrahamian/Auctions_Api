<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthPublicKey;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthPublicKey::class);
    }
}
