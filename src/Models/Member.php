<?php

namespace Mdeskorg\Chat\Models;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['member_id', 'member_type'];

    /**
     * The chats that belong to the Member
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }

    /**
     * Получить участника диалога
     *
     * @return object
     */
    public function member()
    {
        return $this->morphTo('member');
    }

    public function getType()
    {
        switch ($this?->member?->getMorphClass()) {
            case User::class:
                return 'user';
            case Client::class:
                return 'client';
            default:
                return 'admin';
        }
    }

    public function getPhoto()
    {
        if ($this->member->getMorphClass() === Client::class) {
            return $this->member->photo;
        }
    }

    public function getName()
    {
        if ($this->member->getMorphClass() === Client::class) {
            return $this->member->getName();
        } else {
            return $this->member->name;
        }
    }
}
