<?php

use App\Model\Auction\Auction;
use App\Model\Auction\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Auction::all() as $auction) {
            factory(State::class)->create([
                'auction_id'    => $auction->id,
                'current_price' => $auction->current_price,
            ]);
        };
    }
}
