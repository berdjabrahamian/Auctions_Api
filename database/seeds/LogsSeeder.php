<?php

use Illuminate\Database\Seeder;
use App\Model\Auction\Auction;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Auction::all() as $auction) {
            factory(\App\Model\Auction\Log::class)->create([
                'activity' => 'Auction Created',
                'auction_id' => $auction->id,
                'customer_id' => null,
            ]);
            factory(\App\Model\Auction\Log::class)->create([
                'activity' => 'Auction Started',
                'auction_id' => $auction->id,
                'customer_id' => null,
            ]);
        }
    }
}
