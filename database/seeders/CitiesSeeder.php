<?php

namespace Database\Seeders;

use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://gist.githubusercontent.com/alex-oleshkevich/1509c308fabab9e104b5190dab99a77b/raw/b20bd8026deec00205a57d395c0ae1f75cc387bb/ua-cities.json');

        $arr = json_decode($response->getBody()->getContents(), true);

        foreach ($arr[0]['regions'] as $region) {
            $regName = $region['name'];
            foreach ($region['cities'] as $city) {
                $cities[] = $city['name'] . $regName;
                DB::table('cities')->insert([
                   'city' => $city['name'],
                   'region' => $regName,
                ]);
            }
        }
    }
}
