<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedInteger('auction_id');
            $table->foreign('auction_id')->references('id')->on('auctions');
            $table->unsignedInteger('max_bid_id');
            $table->foreign('max_bid_id')->references('id')->on('max_bids');
            $table->boolean('viewed')->default(FALSE);
            $table->timestamp('created_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_notifications');
    }
}
