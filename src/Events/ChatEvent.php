<?php

namespace Mdeskorg\Chat\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Mdeskorg\Chat\Resources\ChatResource;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    public $type;

    /**
     * Create a new event instance.
     */
    public function __construct($chat, $type = 'all')
    {
        $this->chat = $chat;
        $this->type = $type;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return ['chat' => new ChatResource($this->chat)];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new PrivateChannel(match ($this->type) {
            'chat' => 'chat.' . $this->chat->project_id ,
            default => 'chats.' . $this->chat->project_id . '.' . $this->type,
        })];
    }
}
