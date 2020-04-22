<?php

use Illuminate\Database\Seeder;

class NewAuctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Model\Product\Product::class, 100)->create()->each(function ($product) {
            factory(\App\Model\Auction\Auction::class)->create([
                'product_id' => $product->id,
            ])->each(function ($auction) {
                factory(\App\Model\Auction\State::class)->create([
                    'auction_id'    => $auction->id,
                    'current_price' => $auction->current_price,
                ]);
            });
        });

    }
}
