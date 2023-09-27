<?php

namespace Mdeskorg\Chat\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mdeskorg\Chat\Models\Chat;

class ReadMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct($item, $user)
    {
        $this->item = $item;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this?->user?->getMorphClass() === User::class) {
            /** Прочтение сообщений */
            if (get_class($this->item) === Chat::class) {
                $this->readMessages(
                    $this->item->messages()
                        ->whereDoesntHave('reads', fn ($q) => $q->where('member_id', $this->user->member->id))
                        ->get(), $this->user->member->id
                );
            } else {
                $this->readMessages($this->item, $this->user->member->id);
            }
        }
    }

    /**
     * Отметить прочитанные сообщения
     *
     * @param  object  $messages
     * @param  int  $member_id
     * @return object
     */
    public function readMessages($messages, $member_id)
    {
        return $messages->each(fn ($message) => $message->reads()->firstOrCreate([
            'member_id' => $member_id,
        ]));
    }
}
