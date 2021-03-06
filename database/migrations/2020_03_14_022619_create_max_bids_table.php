<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaxBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('max_bids', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('auction_id');
            $table->foreign('auction_id')->references('id')->on('auctions');
            $table->integer('customer_id');
            $table->bigInteger('amount');
            $table->boolean('outbid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('max_bids');
    }
}
