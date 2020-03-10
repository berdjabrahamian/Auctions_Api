<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('code');
            $table->string('contact_email');
            $table->string('contact_number');
            $table->string('public_key');
            $table->string('secret_key');
            $table->smallInteger('hammer_price');
            $table->smallInteger('hammer_type');
            $table->smallInteger('final_extension_threshold');
            $table->smallInteger('final_extension_duration');
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
        Schema::dropIfExists('stores');
    }
}
