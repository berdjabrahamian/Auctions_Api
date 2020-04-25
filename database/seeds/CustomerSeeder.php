<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Model\Customer\Customer::class, 1)->create([
            'email'       => 'test@example.com',
            'first_name'  => 'test',
            'last_name'   => 'example',
            'platform_id' => 1,
        ]);


        factory(\App\Model\Customer\Customer::class, 3)->create();
    }
}
