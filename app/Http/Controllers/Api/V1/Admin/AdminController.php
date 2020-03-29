<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Middleware\AuthSecretKey;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(AuthSecretKey::class);

        parent::__construct();

    }
}
