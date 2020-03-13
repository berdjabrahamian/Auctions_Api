<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Store\Store;
use Faker\Generator as Faker;

$factory->define(store::class, function (Faker $faker) {
    return [
        'name'                      => 'Example Store',
        'url'                       => 'https://example.com',
        'code'                      => 'example_store',
        'contact_email'             => 'example@example.com',
        'contact_number'            => '1234567890',
        'public_key'                => '',
        'secret_key'                => '',
        'hammer_price'              => 100,
        'hammer_type'               => 1,
        'final_extension_threshold' => '0',
        'final_extension_duration'  => '0',
    ];
});

