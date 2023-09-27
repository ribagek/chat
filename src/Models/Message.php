<?php

namespace Mdeskorg\Chat\Models;

use App\Models\Option;
use App\Models\Text;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mdeskorg\Chat\Resources\MessageResource;

class Message extends Model
{
    use BroadcastsEvents, HasFactory;

    public $fillable = ['member_id', 'text_id', 'uniq', 'send', 'option_id', 'created_at'];

    /**
     * Get the channels that model events should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel|\Illuminate\Database\Eloquent\Model>
     */
    public function broadcastOn(string $event): array
    {
        return [new PresenceChannel('chat.' . $this->chat_id)];
    }

    /**
     * Get the data to broadcast for the model.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(string $event): array
    {
        return ['message' => new MessageResource($this)];
    }

    /**
     * Create a new broadcastable model event for the model.
     */
    protected function newBroadcastableEvent(string $event): BroadcastableModelEventOccurred
    {
        return (new BroadcastableModelEventOccurred(
            $this,
            $event
        ))->dontBroadcastToCurrentUser();
    }

    /**
     * Get the text that owns the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function text()
    {
        return $this->belongsTo(Text::class);
    }

    /**
     * Get the member that owns the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get all of the reads for the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reads()
    {
        return $this->hasMany(Read::class);
    }

    /**
     * Get the option that owns the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    /**
     *  Загрузка изображений и сообщений
     *
     * @return array
     */
    public function saveMessage($array, $message_id = null)
    {
        $array = collect($array);

        return [
            'text_id' => $this->getText($array),
            'message_id' => $message_id,
            'uniq' => $array->get('created_at'),
        ];
    }

    /**
     * Получение ID текста
     *
     * @param  object  $array
     * @return null|int
     */
    public function getText($array)
    {
        if ($array->get('text')) {
            return (new Text)->create(['text' => $array->get('text')])->id;
        }
    }
}
