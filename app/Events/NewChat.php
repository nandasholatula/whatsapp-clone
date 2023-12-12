<?php

namespace App\Events;

use App\Models\Dialog;
use ArrayObject;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\UserCred;

class NewChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        // Log::channel('webhook')->info(['Dialog' => Dialog::with('latestMessage')->find($this->data['chatId']), 'message' => $this->data]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }

    public function broadcastWith()
    {
        $dialog = Dialog::find($this->data['chatId']);
        $cred = UserCred::with('user', 'credential')->where('user_id', auth()->id())->first();
        if (!$dialog) {
            $dialog = (object)[];
            $dialog->id = $this->data->chatId;
            $dialog->name = $this->data->chatName;
            $dialog->image = 'https://avatars.dicebear.com/api/initials/' . $this->data->chatName . '.svg';
            $dialog->last_time = date('m/d/Y H:i:s', $this->data['time']);
            $dialog->credential_id = $cred->credential_id;
        }
        $this->data['time'] = date('m/d/Y H:i:s', $this->data['time']);
        $dialog->latest_message = $this->data;
        return ['dialog' => $dialog];
    }
}
