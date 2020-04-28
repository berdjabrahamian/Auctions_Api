<?php

namespace App\Http\Controllers\Api\V1\Admin\Products;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminProductDuplicate;
use App\Model\Product\Product;

/**
 * Class DuplicateController
 *
 * @package App\Http\Controllers\Api\V1\Admin\Products
 *
 * This is specifically for products that are created in the api system rather than in a cms
 *
 */
class DuplicateController extends AdminController
{
    /**
     * Handle the incoming request.
     *
     * @param  AdminProductDuplicate  $request
     *
     * @return void
     */
    public function __invoke(AdminProductDuplicate $request)
    {
        $validated = $request->validated();

        $product = $request->getProduct()->replicate($validated);

        $product->save();
        dd($product);

    }


}
