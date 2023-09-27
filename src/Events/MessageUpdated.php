<?php

namespace Mdeskorg\Chat\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageUpdated implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  protected $user;
  protected $message;
  protected $message_id;
  protected $chat;

  public function __construct($message_id, User $user, $message)
  {
    $this->message_id = $message_id;
    $this->user = $user;
    $this->message = $message;
  }

  public function broadcastWith()
  {
    // This must always be an array. Since it will be parsed with json_encode()
    return [
      'user' => $this->user->name,
      'message' => $this->message,
      'message_id' => $this->message_id,
    ];
  }

  public function broadcastAs()
  {
    return 'messageUpdated';
  }

  public function broadcastOn()
  {
    return new PrivateChannel('chat.' . $this->message->chat_id);
  }
}
