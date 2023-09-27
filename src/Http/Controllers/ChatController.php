<?php

namespace Mdeskorg\Chat\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mdeskorg\Chat\Http\Requests\MessageRequest;
use Mdeskorg\Chat\Jobs\FilterChats;
use Mdeskorg\Chat\Jobs\ReadMessages;
use Mdeskorg\Chat\Models\Chat;
use Mdeskorg\Chat\Models\Message;
use Mdeskorg\Chat\Resources\ChatResource;
use Mdeskorg\Chat\Resources\MessageResource;
use Mdeskorg\Chat\Services\Filters\ChatFilter;

class ChatController extends Controller
{
    /**
     * Получить все чаты
     *
     * @return object
     */
    public function index(ChatFilter $request)
    {
        $project = Project::first();

        return ChatResource::collection(
            $project->chats()
                ->selectRaw('chats.*, (SELECT MAX(created_at) from messages WHERE messages.chat_id=chats.id) as latest_message_on')
                ->orderBy('latest_message_on', 'DESC')
                ->filter($request)
                ->simplePaginate(30)
        );
    }

    /**
     * Get the available disks
     */
    public function show(Chat $chat)
    {
        if (request('unread')) {
            ReadMessages::dispatch($chat, auth()->user());
        } else {
            return new ChatResource($chat);
        }
    }

    /**
     * Get the available disks
     */
    public function messages(Chat $chat)
    {
        $messages = $chat->messages()
            ->orderByDesc('id')->cursorPaginate(30)->withPath(null);

        ReadMessages::dispatch($messages, auth()->user());

        return MessageResource::collection($messages);
    }

    /**
     * Get the available disks
     */
    public function store(Chat $chat, MessageRequest $request)
    {
        $user = User::first();
        $message = (new Message)->saveMessage($request->validated());

        // dispatch(function () use ($chat, $user, $message) {
        //     $chat->addMessage($user, $message);
        // });

        return new MessageResource($chat->addMessage($user, $message));
    }

    /**
     * Добавить / Убрать из важных
     *
     * @param  object  $chat
     * @return void
     */
    public function star(Chat $chat, Request $request)
    {
        $user = User::first();
        //auth()->user()->member->id

        $chat->stars()->firstOrCreate(
            ['member_id' => $user->member->id],
            $request->validate([
                'star' => ['required', 'boolean'],
            ])
        );

        FilterChats::dispatch($chat);
    }

    /**
     * Сменить описание для клиента
     *
     * @param  object  $chat
     * @return void
     */
    public function description(Chat $chat, Request $request)
    {
        $client = $chat->client()->first();

        if ($client) {
            $client->member->update($request->validate([
                'description' => ['nullable', 'string', 'between:1,2048'],
            ]));

            FilterChats::dispatch($chat);
        }
    }
}
