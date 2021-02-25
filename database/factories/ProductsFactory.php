<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    return [
        'store_id'    => 1,
        'sku'         => $faker->bothify('##??#?#?##?'),
        'name'        => $faker->text,
        'description' => $faker->sentence,
        'platform_id' => $faker->bothify('######'),
        'image_url'   => 'https://i.picsum.photos/id/0/5616/3744.jpg?hmac=3GAAioiQziMGEtLbfrdbcoenXoWAW-zlyEAMkfEdBzQ',
        'product_url' => $faker->url,
    ];
});
