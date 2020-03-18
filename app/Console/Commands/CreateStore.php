<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Model\Store\Store;

class CreateStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a store to connect to auctions api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $store = $this->createNewStore();

        $this->info('New Store Created');

    }

    // TODO: Finish actually creating a store in the DB
    protected function createNewStore()
    {
        $this->line('');
        $this->line('Lets walk through the process of creating a new store');
        $name          = $this->ask('Store Name? (eg: Auction House Ltd)');
        $url           = $this->ask('Store Website? (eg: https://www.auctionhouse.com)');
        $contactEmail  = $this->ask('Contact Email? (eg: auction@house.com)');
        $contactNumber = $this->ask('Contact Phone Number? (eg: 1112223333)');


        $this->line('The Hammer Price is a value added on top of the auction winning price');
        $this->line('The value added will be based on whether you choose to use percent or a dollar value');
        $this->line('eg: If Auction was won at $150 and Hammer Price is set to 20 and Hammer Type is set to $ (dollar value)');
        $this->line('The value of the auction will be $170 ($150 + 20)');
        $this->line('eg: If Auction was won at $150 and Hammer Price is set to 20 and Hammer Type is set to % (percent)');
        $this->line('The value of the auction will $180 ((20% of $150 = $30) + $150)');

        $hammerType  = $this->ask('Do you wish to use $ | % | None? ($,%,0)');
        $hammerPrice = $this->ask('What is the value you wish to use for the Hammer Price? 0 = Nothing');

        $this->line('The Final Extension Threshold is what we would call GOING GOING GONE');
        $this->line('Its how much time in seconds should we add to the auction when a last minute bid is placed.');
        $this->line('You can set that if there is 2 min (120 sec) left to an auction and a last min bid is placed, then add an addition 1 min (60 sec) to the auction');

        $finalExtensionDuration  = $this->ask('How much time in seconds to add when a last minute bid is placed in seconds. (0 = Nothing)');
        $finalExtensionThreshold = $this->ask('How much time in seconds should there be left for the duration to kick in, in seconds. (0 = Nothing)');


        $validator = Validator::make([
            'name'                      => $name,
            'url'                       => $url,
            'contact_email'             => $contactEmail,
            'contact_number'            => $contactNumber,
            'hammer_type'               => $hammerType,
            'hammer_price'              => $hammerPrice,
            'final_extension_duration'  => $finalExtensionThreshold,
            'final_extension_threshold' => $finalExtensionThreshold,
        ], [
            'name'                      => 'required|string',
            'url'                       => 'required|url',
            'contact_email'             => 'required|email',
            'contact_number'            => 'required|numeric|min:10',
            'hammer_type'               => ['required', Rule::in(['%', '$', '0'])],
            'hammer_price'              => 'required|numeric',
            'final_extension_duration'  => 'required|numeric',
            'final_extension_threshold' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $this->info('Store not created as some of the fields were not');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            $this->error('There was an error with the information provided.');
            $this->error('----');
            $this->error('----');
            $startAgain = $this->choice('Start Again?', ['No', 'Yes']);

            if ($startAgain == 1) {
                $this->createNewStore();
            } else {
                $this->info('Aborting');
                exit;
            }
        }

        return true;
    }


}
