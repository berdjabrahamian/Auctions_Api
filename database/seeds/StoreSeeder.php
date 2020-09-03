<?php

use Illuminate\Database\Seeder;
use Illuminate\Encryption\Encrypter;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Store\Store::class, 1)->create([
            'public_key' => 'pk_12345',
            'secret_key' => 'sk_12345',
        ]);

        $options = new \App\Model\Store\Options([
           'store_id' => 1,
           'customer_data_hidden' => true,
           'absolute_auction_max_bid_amount' => 1000,
        ]);

        $options->save();
    }


    public function generateKeys()
    {
        return base64_encode(Encrypter::generateKey(config('app.cipher')));
    }
}
