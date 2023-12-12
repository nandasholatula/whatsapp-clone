<?php

namespace App\Console\Commands;

use App\Models\Credential;
use App\Models\Dialog;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetDialogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dialogs';

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
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $credentials = Credential::all();
        foreach ($credentials as $cred) {

            $result = json_decode($client->request('GET', $cred->instance . 'dialogs?token=' . $cred->token . '&limit=50')
                ->getBody()
                ->getContents());

            foreach ($result->dialogs as $key => $res) {
                $dialog = Dialog::where('id', $res->id);
                // Log::info([$res->metadata->isGroup]);
                if ($dialog->first()) {
                    $dialog->update([
                        'credential_id' => $cred->id,
                        'name' => $res->name,
                        'last_time' => date('Y-m-d H:i:s', $res->last_time)
                    ]);
                } else {
                    if (!@getimagesize($res->image)) {
                        $res->image = 'https://avatars.dicebear.com/api/initials/' . $res->name . '.svg';
                        // Log::info([$key, $res->image]);
                    }
                    Dialog::Create([
                        'id' => $res->id,
                        'credential_id' => $cred->id,
                        'name' => $res->name,
                        'image' => $res->image,
                        'is_group' => $res->metadata->isGroup,
                        'last_time' => date('Y-m-d H:i:s', $res->last_time)
                    ]);
                }
            }
        }
        Log::info('dialogs ok');
        return 0;
    }
}
