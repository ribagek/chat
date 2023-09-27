<?php

namespace Mdeskorg\Chat\Resources;

use App\Models\Client;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $client = $this->client()->first()?->member;

        return [
            'id' => $this->id,
            'chat' => [
                'id' => $this->id,
                'name' => $client ? $client->getName() : 'DELETED',
                'created_at' => $this->created_at,
                'unread' => $this->getUnReads(),
                'star' => $this->stars()->exists(),
                'message' => new MessageResource($this->getMessage()),
                'members' => $this->getMembers(),
                'photo' => $client?->photo ?? '?',
              //duplicated robot array to match data format on front-end
                'robot' => [
                  'id' => $client?->robot->id,
                  'name' => $client?->robot->name,
                  'bot' => [
                    'title' => $client?->robot->bot->title,
                    'photo' => $client?->robot->bot->title ? '/images/bot/' . $client?->robot->bot->title . '.png' : null,
                  ],
                ],
            ],
            'details' => [
                'id' => $client?->id,
                'title' => $client ? $client->getName() : 'DELETED',
                'photo' => $client?->photo ?? '?',
                'unique' => $client?->unique,
                'description' => $client?->description,
                'created_at' => $client?->created_at,
                'updated_at' => $client?->updated_at,
                'robot' => [
                    'id' => $client?->robot->id,
                    'name' => $client?->robot->name,
                    'bot' => [
                        'title' => $client?->robot->bot->title,
                        'photo' => $client?->robot->bot->title ? '/images/bot/' . $client?->robot->bot->title . '.png' : null,
                    ],
                ],
            ],
        ];
    }

    /**
     * Получить участников диалога
     *
     * @return object
     */
    public function getMembers()
    {
        return $this->members()->with('member')
            ->where('member_type', '!=', Client::class)
            ->get()->map(fn ($member) => [
                'name' => $member->member->name,
                'photo' => $member->member->photo,
                'added_at' => $member->pivot->added_at,
            ]);
    }

    /**
     * Получить последнее сообщение
     *
     * @return object
     */
    public function getMessage()
    {
        return $this->messages()
            ->when(request()->get('search'), function ($q) {
                $q->whereHas(
                    'text',
                    fn ($q) => $q->where('text', 'LIKE', '%' . request()->get('search') . '%')
                );
            })
            ->latest('id')->first();
    }
}
