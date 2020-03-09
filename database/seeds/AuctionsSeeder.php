<?php

use Illuminate\Database\Seeder;
use App\Model\Product\Products as Products;

class AuctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Products::all() as $product) {
            factory(\App\Model\Auction\Auctions::class)->create([
                'product_id' => $product->id,
            ]);
        };

    }
}
