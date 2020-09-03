<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbsoluteAuctionMaxBidAmountToStoreOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_options', function (Blueprint $table) {
            $table->unsignedInteger('absolute_auction_max_bid_amount')->nullable()->comment('Maximum Value the customer can bid on an absolute auction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_options', function (Blueprint $table) {
            $table->dropColumn('absolute_auction_max_bid_amount');
        });
    }
}
