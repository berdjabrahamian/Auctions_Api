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
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends AdminController
{
    /**
     * Display all products
     *
     * @param  AdminProductIndex  $request
     *
     * @return AdminProductCollection
     *
     * Done
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
     *
     * DONE
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
     *
     * Done
     */
    public function show($id)
    {
        try {
            $product = Store::getCurrentStore()->products()->where('pub_id', $id)->firstOrFail();

            return new AdminProductsResource($product);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product Not Found'], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminProductUpdate  $request
     * @param  int                 $id
     *
     * @return \Illuminate\Http\Response
     *
     * DONE
     */
    public function update(AdminProductUpdate $request, $id)
    {
        $validated = $request->validated();

        try {
            $product = Store::getCurrentStore()->products()->where([
                'pub_id' => $id,
            ])->firstOrFail();


            if (isset($validated['name'])) {
                $product->name = $validated['name'];
            }
            if (isset($validated['description'])) {
                $product->description = $validated['description'];
            }
            if (isset($validated['image_url'])) {
                $product->image_url = $validated['image_url'];
            }

            $product->save();

            return $product;

        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Product Not Found'], 404);

        }
    }

    /**
     * TODO Finish This
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['error' => 'Unauthorized'], 422);
    }
}
