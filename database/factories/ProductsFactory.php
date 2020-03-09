<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'store_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9,0]),
        'sku' => $faker->bothify('##??#?#?##?'),
        'name' => $faker->text,
        'description' => $faker->sentence,
        'platform_id' => $faker->bothify('##??#?#?##?'),
        'image_url' => $faker->imageUrl(),
        'product_url' => $faker->url,
    ];
});
