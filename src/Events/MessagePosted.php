<?php

namespace Mdeskorg\Chat\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessagePosted implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  protected $user;
  protected $message;
  protected $chat;

  public function __construct(User $user, $message)
  {
    $this->user = $user;
    $this->message = $message;
  }

  public function broadcastWith()
  {
    // This must always be an array. Since it will be parsed with json_encode()
    return [
      'user' => $this->user->name,
      'message' => $this->message,
    ];
  }

  public function broadcastAs()
  {
    return 'messagePosted';
  }

  public function broadcastOn()
  {
    return new PrivateChannel('chat.' . $this->message->chat_id);
  }
}
