<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthPublicKey;

/**
 * Class BaseController
 *
 * @package App\Http\Controllers\Api\V1
 *
 * The whole point of this is to control the middleware
 * that checks if the user is using the right keys
 * This can be called fom the routes as well
 * but its sitting here live with it
 */
class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthPublicKey::class);
    }
}
