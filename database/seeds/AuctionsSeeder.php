<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Model\Product\Product;
use Illuminate\Support\Facades\DB;

class AuctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->orderBy('id', 'asc')->chunk(10, function ($products) {
            foreach ($products as $product) {
                factory(\App\Model\Auction\Auction::class)->create([
                    'product_id' => $product->id,
                ]);
            };
        });
    }
}
