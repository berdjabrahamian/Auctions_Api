<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'store_id' => 1,
        'sku' => $faker->bothify('##??#?#?##?'),
        'name' => $faker->text,
        'description' => $faker->sentence,
        'platform_id' => $faker->bothify('######'),
        'image_url' => $faker->imageUrl(),
        'product_url' => $faker->url,
    ];
});
