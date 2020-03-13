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
            'public_key' => 'pk_' . $this->generateKeys(),
            'secret_key' => 'sk_' . $this->generateKeys(),
        ]);
    }


    public function generateKeys()
    {
        return base64_encode(
            Encrypter::generateKey(config('app.cipher'))
        );
    }
}
