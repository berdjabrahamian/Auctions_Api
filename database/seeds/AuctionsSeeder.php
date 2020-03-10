<?php

use Illuminate\Database\Seeder;
use App\Model\Product\Product;

class AuctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Product::all() as $product) {
            factory(\App\Model\Auction\Auction::class)->create([
                'product_id' => $product->id,
            ]);
        };

    }
}
