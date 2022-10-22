<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
            $api_layer_key = \config('global-variables.api_layer_key');

            if (!$dateNow->isWeekend()) {
                \Log::info("_____________________________________________________________________");
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/latest?symbols=PLN&base=USD",
                  CURLOPT_HTTPHEADER => array(
                    "Content-Type: text/plain",
                    "apikey: $api_layer_key"
                  ),
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET"
                ));

                $response = curl_exec($curl);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                //SMS API
                $basic  = new \Vonage\Client\Credentials\Basic($vonage_user_id, $vonage_usser_secret_key);
                $client = new \Vonage\Client($basic);

                if ($httpcode == 200) {
                    $array = json_decode($response, true);
                    $rates = $array['rates']['PLN'];

                    if ($rates < 4.84) {
                        $message = implode("", ["USD reached: ", $rates, " PLN"]);
                        $msg_response = $client->sms()->send(
                            new \Vonage\SMS\Message\SMS($vonage_user_tel, 'Currency', $message)
                        );

                        $message = $msg_response->current();

                        if ($message->getStatus() == 0) {
                            \Log::info("SMS sent succesfully!");
                        } else {
                            \Log::info($message->getStatus());
                        }
                    }
            } else {
                \Log::info("CURRENCY FETCH ERROR!");
            }
        }

        \Log::info("Cron is working fine!");

        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
    }
}
