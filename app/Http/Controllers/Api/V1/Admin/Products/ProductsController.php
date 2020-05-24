<?php

namespace App\Http\Controllers\Api\V1\Admin\Products;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminProductIndex;
use App\Http\Requests\AdminProductStore;
use App\Http\Requests\AdminProductUpdate;
use App\Http\Resources\AdminProductCollection;
use App\Http\Resources\AdminProductsResource;
use App\Model\Product\Product;
use App\Model\Store\Store;
use Illuminate\Http\Request;

class ProductsController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return AdminProductCollection
     */
    public function index(AdminProductIndex $request)
    {
        $validated = $request->validated();

        $products = Store::getCurrentStore()->products();

        if (isset($validated['product_ids'])) {
            $products->withProductIds($validated['product_ids']);
        }

        return new AdminProductCollection($products->paginate());
    }


    /**
     * Create a new Product
     *
     * @param  AdminProductStore  $request
     *
     * @return AdminProductsResource
     */
    public function store(AdminProductStore $request)
    {
        $validated = $request->validated();

        $product = new Product();

        $product->name        = $validated['name'];
        $product->sku         = $validated['sku'];
        $product->platform_id = $validated['platform_id'];
        $product->description = $validated['description'];
        $product->image_url   = $validated['image_url'];
        $product->product_url = $validated['product_url'];

        $product->store()->associate(Store::getCurrentStore());
        $product->save();

        return new AdminProductsResource($product);

    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Store::getCurrentStore()->products()->find($id);

        return new AdminProductsResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProductUpdate $request, $id)
    {
        $validated = $request->validated();

        $product = Store::getCurrentStore()->products()->where([
            'id' => $id,
        ])->firstOrFail();

        $product->name        = $validated['name'];
        $product->description = $validated['description'];
        $product->image_url   = $validated['image_url'];
        $product->product_url = $validated['product_url'];

        $product->save();

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json('Error', 422);
    }
}
