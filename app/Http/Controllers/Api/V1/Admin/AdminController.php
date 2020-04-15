<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Middleware\AuthSecretKey;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Api\V1\Admin
 *
 * The whole point of this is to control the middleware
 * that checks if the user is using the right keys
 * This can be called fom the routes as well
 * but its sitting here live with it
 */
class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(AuthSecretKey::class);

        parent::__construct();

    }
}
