<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Auction\Auction;
use Faker\Generator as Faker;

$factory->define(Auction::class, function (Faker $faker) {
    return [
        'product_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]),
        'store_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]),
        'name' => $faker->text,
        'status' => $faker->boolean,
        'initial_price' => 100,
        'min_bid' => 1,
        'is_buyout' => $faker->boolean,
        'buyout_price' => 9999,
        'start_date' => $faker->iso8601,
        'end_date' => $faker->iso8601,
    ];
});
