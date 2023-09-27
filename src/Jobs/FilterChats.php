<?php

namespace Mdeskorg\Chat\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mdeskorg\Chat\Events\ChatEvent;

class FilterChats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chat;

    /**
     * Create a new job instance.
     */
    public function __construct($chat)
    {
        $this->chat = $chat;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filters = collect(['all', 'chat']);

        if ($this->chat->getUnReads() > 0) {
            $filters->push('unanswered');
        }
        
        //commented this check - it prevented event from firing when star is unchecked
//        if ($this->chat->stars()->exists()) {
            $filters->push('favorite');
//        }

        $filters->each(fn ($filter) => ChatEvent::dispatch($this->chat, $filter));
    }
}
