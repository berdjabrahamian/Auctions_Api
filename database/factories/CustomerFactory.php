<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Customer\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'email'       => $faker->email,
        'first_name'  => $faker->firstName,
        'last_name'   => $faker->lastName,
        'platform_id' => $faker->numerify('###'),
        'store_id'    => 1,
        'approved'    => TRUE,
    ];
});
