<?php

namespace Mdeskorg\Chat\Services;

use App\Models\Option;
use Mdeskorg\Chat\Models\Member;

final class ChatNotificationHandler
{
    public function create($array)
    {
        $array = collect($array);

        if (method_exists($this, (string) $array->get('type'))) {
            return (new Option)->add($array->toArray())->id;
        }
    }

    public function show($option)
    {
        $option = collect($option);

        if (method_exists($this, (string) $option->get('type'))) {
            $text = call_user_func_array([$this, $option->get('type')], [$option]);

            return $option->merge(['text' => $text]);
        }
    }

    /** FUNCTIONS */
    public function added($option)
    {
        $member = Member::find($option->get('member_id'));

        if ($member) {
            $name = $member->getName();
            $type = $member->getType();
        } else {
            $name = '?';
            $type = '?';
        }

        return $type . ' ' . $name . ' присоединился к чату';
    }
}
