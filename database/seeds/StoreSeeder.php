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
    }


    public function generateKeys()
    {
        return base64_encode(Encrypter::generateKey(config('app.cipher')));
    }
}
