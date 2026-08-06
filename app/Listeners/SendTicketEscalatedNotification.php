<?php

namespace App\Listeners;

use App\Events\TicketEscalated;
use App\Services\TelegramBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendTicketEscalatedNotification implements ShouldQueue
{
    public function handle(TicketEscalated $event): void
    {
        try {
            $bot = app(TelegramBotService::class);
            $ticket = $event->ticket;

            $text = "🚨 <b>Eskalasi Tiket #{$ticket->id}</b>\n\n"
                . "Subjek: {$ticket->subject}\n"
                . "Pelapor: {$ticket->user?->name}\n"
                . "Aplikasi: {$ticket->app?->name}\n"
                . "Prioritas: {$ticket->priority}\n"
                . "Sumber: {$ticket->source}\n\n"
                . "Gunakan /assign #{$ticket->id} untuk menangani tiket ini.\n"
                . "Gunakan /resolve #{$ticket->id} untuk menyelesaikan.";

            $bot->forwardToAdmin($text);
        } catch (\Exception $e) {
            Log::error('Gagal eskalasi ke admin', ['error' => $e->getMessage()]);
        }
    }
}
