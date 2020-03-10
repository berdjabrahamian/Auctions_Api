<?php

use Illuminate\Database\Seeder;
use App\Model\Auction\Auctions;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Auctions::all() as $auction) {
            factory(\App\Model\Auction\Logs::class)->create([
                'activity' => 'Auction Created',
                'auction_id' => $auction->id,
            ]);
            factory(\App\Model\Auction\Logs::class)->create([
                'activity' => 'Auction Started',
                'auction_id' => $auction->id,
            ]);
            factory(\App\Model\Auction\Logs::class)->create([
                'activity' => 'Auction Ended',
                'auction_id' => $auction->id,
            ]);
        }
    }
}
