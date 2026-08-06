<?php

namespace App\Jobs;

use App\Models\Ticket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessTicketWithAI implements ShouldQueue
{
    use Queueable;

    public function __construct(public Ticket $ticket)
    {
        //
    }

    /**
     * Phase 3 will implement the actual AI processing via OpenRouter.
     * For now, this stub escalates the ticket.
     */
    public function handle(): void
    {
        Log::info('ProcessTicketWithAI — stub', [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
        ]);

        // Mark as escalated (AI not implemented yet)
        $this->ticket->transitionTo('escalated');

        // Fire escalated event — Phase 3 will add AI response before this
        event(new \App\Events\TicketEscalated($this->ticket));
    }
}
