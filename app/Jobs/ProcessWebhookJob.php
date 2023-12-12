<?php

namespace App\Jobs;

use App\Events\NewChat;
use App\Events\StatusChange;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Log;
use \Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhookJob extends SpatieProcessWebhookJob
{
    public function handle()
    {
        $data = json_decode($this->webhookCall, true);

        Log::channel('webhook')->info('Starting webhook');
        Log::channel('webhook')->info($data);
        // Log::info('Starting webhook');

        if (isset($data['payload']) && isset($data['payload']['messages'][0])) {
            broadcast(new NewMessage($data['payload']['messages'][0]));
            broadcast(new NewChat($data['payload']['messages'][0]));
        }
        if (isset($data['payload']) && isset($data['payload']['status']) && $data['payload']['status']) {
            Log::channel('webhook')->info($data['payload']['status']);
            broadcast(new StatusChange($data['payload']['status']));

            // broadcast(new NewChat($data['payload']['messages'][0]));
        }
    }
}
