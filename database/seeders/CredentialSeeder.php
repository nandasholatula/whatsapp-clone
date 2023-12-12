<?php

namespace Database\Seeders;

use App\Models\Credential;
use Illuminate\Database\Seeder;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Credential::firstOrCreate([
            'chatId' => '628119523022@c.us',
            'phone' => '628119523022',
            'name' => 'Sistem BNSP & Infopelatihan',
            'instance' => 'https://eu61.chat-api.com/instance152953/',
            'token' => 't1b8ecaydchc89fz'
        ]);
    }
}
