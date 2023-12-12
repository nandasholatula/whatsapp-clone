<?php

namespace Database\Seeders;

use App\Models\UserCred;
use Illuminate\Database\Seeder;

class UserCredSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCred::firstOrCreate([
            'user_id' => 1,
            'credential_id' => 1,
            'active' => true
        ]);
    }
}
