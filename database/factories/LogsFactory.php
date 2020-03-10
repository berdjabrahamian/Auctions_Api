<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Auction\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'auction_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]),
        'store_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]),
        'activity' => 'Auction Created',
        'customer_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]),
    ];
});
