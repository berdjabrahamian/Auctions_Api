<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('store_id');
            $table->string('name');
            $table->boolean('status');
            $table->integer('initial_price')->comment('Initial Starting Price');
            $table->integer('min_bid')->comment('Minimum Bid on Auction');
            $table->boolean('is_buyout');
            $table->integer('buyout_price')->comment('Buyout Price');
            $table->timestamp('start_date', 0)->nullable();
            $table->timestamp('end_date', 0)->nullable();
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
        Schema::dropIfExists('auctions');
    }
}
