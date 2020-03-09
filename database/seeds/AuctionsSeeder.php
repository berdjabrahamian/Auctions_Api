<?php

use Illuminate\Database\Seeder;

class AuctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Model\Auction\Auctions::class, 50)->create();
    }
}
