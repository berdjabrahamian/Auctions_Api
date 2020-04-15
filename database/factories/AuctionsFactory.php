<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Auction\Auction;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Auction::class, function (Faker $faker) {
    return [
        'product_id'    => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]),
        'store_id'      => 1,
        'name'          => $faker->text,
        'status'        => TRUE,
        'initial_price' => 100,
        'min_bid'       => 1,
        'is_buyout'     => $faker->boolean,
        'buyout_price'  => 9999,
        'start_date'    => Carbon::now(),
        'end_date'      => Carbon::now()->addMinutes(330),
        'current_price' => 100,
    ];
});
