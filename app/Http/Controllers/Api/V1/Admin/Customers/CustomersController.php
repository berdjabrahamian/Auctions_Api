<?php

namespace App\Http\Controllers\Api\V1\Admin\Customers;

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Requests\AdminCustomerStore;
use App\Http\Resources\AdminCustomerResource;
use App\Model\Customer\Customer;
use App\Model\Store\Store;
use Illuminate\Http\Request;

class CustomersController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCustomerStore $request)
    {
        $validated = $request->validated();

        $customer = new Customer();

        $customer->email       = $validated['email'];
        $customer->first_name  = $validated['first_name'];
        $customer->last_name   = $validated['last_name'];
        $customer->platform_id = $validated['platform_id'];
        $customer->approved    = $validated['approved'];
        $customer->store()->associate(Store::getCurrentStore());
        $customer->save();

        return new AdminCustomerResource($customer->withoutRelations());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
