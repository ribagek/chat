<?php

namespace Mdeskorg\Chat\Models;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mdeskorg\Chat\Jobs\FilterChats;
use Mdeskorg\Chat\Jobs\ReadMessages;
use Mdeskorg\Chat\Services\ChatNotificationHandler;
use Mdeskorg\Chat\Services\Filters\QueryFilter;

class Chat extends Model
{
    use HasFactory;

    /**
     * Get the project that owns the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get all of the stars for the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stars()
    {
        return $this->hasMany(Star::class);
    }

    /**
     * The members that belong to the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class)->withPivot('added_at');
    }

    /**
     * The members that belong to the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(Member::class)->where('member_type', Client::class)->withPivot('added_at');
    }

    /**
     * Клиент чата
     *
     * @return object
     */
    public function client()
    {
        return $this->members()->where('member_type', Client::class)->with('member');
    }

    /**
     * Get all of the messages for the Chat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Отправка сообщения в чат
     *
     * @param  int  $member_id
     * @param  array  $messageData
     * @return object
     */
    public function sendMessage($messageData = [], $member_id = null)
    {
        if (isset($messageData['message_id']) && $messageData['message_id']) {
          $message_id = $messageData['message_id'];
          unset($messageData['message_id']);
          
          $message = $this->messages()->where('id', $message_id)->first();
          $message->fill($messageData);
          $message->save();
          
          return $message;
        } else {
          return $this->messages()->create([
              'member_id' => $member_id,
            ] + $messageData);
        }
    }

    /**
     * Добавление в чат
     *
     * @param  object  $item
     * @return object
     */
    public function addToChat($item)
    {
        $member = $item->member()->firstOrCreate([
            'member_type' => $item->getMorphClass(),
            'member_id' => $item->id,
        ]);

        if ($this->members()->where('chat_member.member_id', $member->id)->doesntExist()) {
            $this->members()->attach($member->id);

            /** Уведомление о вступлении в чат  */
            $this->sendMessage([
                'send' => 'success',
                'option_id' => (new ChatNotificationHandler)->create([
                    'type' => 'added',
                    'member_id' => $member->id,
                ]),
            ]);
        }

        return $member;
    }

    /**
     * Получить непрочитанные сообщения чата
     *
     * @return int
     */
    public function getUnReads()
    {
        return $this->where('id', $this->id)->withCount([
            'messages as unread_messages' => fn ($q) => $q->whereDoesntHave('reads'),
        ])->value('unread_messages');
    }

    /**
     * Отправка сообщений в чат
     *
     * @param  object  $item
     * @param  object|array  $messageData
     * @return void
     */
    public function addMessage($item, $messageData)
    {
        $member = $this->addToChat($item);
        $message = $this->sendMessage($messageData, $member->id);

        /** Отправка в социальные сети */
        // try {
        //     if (method_exists($member->member,  'sendChatMessage'))
        //         $member->member->sendChatMessage($message);

        //     $message->update(['send' => 'success']);
        // } catch (\Throwable $th) {
        //     $message->update(['send' => 'failed']);
        // }

        $message->update(['send' => 'success']);

        /** Прочитать сообщения */
        ReadMessages::dispatch($this, $item);
        FilterChats::dispatch($this);

        return $message->fresh();
    }

    /**
     * Фильтрация диалогов
     *
     * @return object
     */
    public function scopeFilter($builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }
}
