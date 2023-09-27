<?php

namespace Mdeskorg\Chat\Services\Filters;

class ChatFilter extends QueryFilter
{
    public function search($search = null)
    {
        if ($search) {
            $this->builder
                ->whereHas('messages',
                    fn ($query) => $query->whereHas('text', fn ($q) => $q->where('text', 'LIKE', '%' . $search . '%')));
        }
    }

    public function filter($value)
    {
        if ($value == 'star') {
            $this->builder->whereHas('stars');
        }

        if ($value == 'unread') {
            $this->builder
                ->withCount(['messages as unread_messages' => fn ($q) => $q->whereDoesntHave('reads')])
                ->having('unread_messages', '>', 0);
        }
    }
}
