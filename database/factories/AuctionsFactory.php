<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Auction\Auction;
use Carbon\Carbon;
use Faker\Generator as Faker;

//Auction::flushEventListeners();

$factory->define(Auction::class, function (Faker $faker) {

    $price = $faker->numerify('###');
    return [
        'product_id'    => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]),
        'store_id'      => 1,
        'name'          => $faker->text(40),
        'status'        => 'enabled',
        'initial_price' => $price,
        'min_bid'       => 1,
        'is_buyout'     => $faker->boolean,
        'buyout_price'  => 9999,
        'bids_count'    => 0,
        'start_date'    => Carbon::now(),
        'end_date'      => Carbon::now()->addMinutes(25),
        'type'          => $faker->randomElement(['absolute', 'min_bid', 'sealed_bid']),
    ];
});
