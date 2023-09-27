<?php

namespace Mdeskorg\Chat\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Mdeskorg\Chat\Services\ChatNotificationHandler;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uniq' => $this->uniq,
            'created_at' => $this->created_at,
            'send' => $this->send,
            'text' => $this?->text?->text,
            'sender' => [
                'id' => $this?->member_id,
                'name' => $this?->member?->getName(),
                'photo' => $this?->member?->getPhoto(),
                'type' => $this?->member?->getType() ?? 'admin',
            ],
            'options' => $this?->option ? (new ChatNotificationHandler)->show($this->option->option) : null,
            'readers' => $this->getReaders(),
        ];
    }

    /**
     * Получить тех, кто прочитал сообщение
     *
     * @return object
     */
    public function getReaders()
    {
        return $this->reads()->with('member')->get()
            ->map(fn ($read) => ['id' => $read->member->member_id, 'name' => $read->member->getName()]);
    }
}
