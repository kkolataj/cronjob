<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Carbon\Carbon;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

            $dateNow = Carbon::now();
            $vonage_user_id = \config('global-variables.vonage_user_id');
            $vonage_usser_secret_key = \config('global-variables.vonage_usser_secret_key');
            $vonage_user_tel = \config('global-variables.vonage_user_tel');

            if (!$dateNow->isWeekend()) {
                // Guzzle fetch
                $client = new Client(['verify' => false]);
                $url = implode("", ['https://api.nbp.pl/api/exchangerates/rates/c/usd/', $dateNow->format('Y-m-d'), '/?format=json']);


                \Log::info("_____________________________________________________________________");
                \Log::info($url);

                $res = $client->request('GET', $url);

                $basic  = new \Vonage\Client\Credentials\Basic($vonage_user_id, $vonage_usser_secret_key);
                $client = new \Vonage\Client($basic);

                if ($res->getStatusCode() == 200) {
                    $content = $res->getBody()->getContents();
                    $array = json_decode($content, true);
                    $rates = $array['rates'][0]['ask'];

                    if ($rates > 5) {
                        \Log::info('More than 1');
                    }
                    // if ($rates < 4.80) {
                        $message = implode("",["USD reached: ", $rates, " PLN"]);
                        $response = $client->sms()->send(
                            new \Vonage\SMS\Message\SMS($vonage_user_tel, 'Currency alert', $message)
                        );
                    // }
            } else {
                \Log::info("NBP FETCH ERROR!");
            }
        }

        \Log::info("Cron is working fine!");

        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
    }
}
