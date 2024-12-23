<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $message;

    // Constructor to pass the message to the event
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    // Define the channel on which the event will be broadcasted
    public function broadcastOn()
    {
        return new Channel('chat.' . $this->message->conversation_id);
    }

    // Define the event name when broadcasting
    public function broadcastAs()
    {
        return 'message.sent';
    }

    // Define the data to be broadcasted
    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'sender_id' => $this->message->sender_id,
            'sender' => [
                'username' => $this->message->sender->username,
            ],
            'sent_at' => $this->message->created_at->format('H:i d-m-Y'),
        ];
    }
}
