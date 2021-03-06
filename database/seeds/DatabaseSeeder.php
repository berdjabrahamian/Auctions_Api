<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(AuctionsSeeder::class);
//        $this->call(StateSeeder::class);
//        $this->call(LogsSeeder::class);
    }
}
