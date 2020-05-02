<?php

namespace App\Http\Controllers\Api\V1\Admin\Products;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminProductStore;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminProductCollection(Product::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = Product::where([
            ['products.id', $id],
            ['products.store_id', Store::getCurrentStore()->id],
        ])->first();

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
    public function update(Request $request, $id)
    {
        //
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
        //
    }
}
