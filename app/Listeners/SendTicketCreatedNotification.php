<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Services\TelegramBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendTicketCreatedNotification implements ShouldQueue
{
    public function handle(TicketCreated $event): void
    {
        if ($event->ticket->source !== 'telegram') {
            return;
        }

        try {
            $bot = app(TelegramBotService::class);
            $user = $event->ticket->user;

            $text = "✅ <b>Tiket Berhasil Dibuat</b>\n\n"
                . "Nomor: #{$event->ticket->id}\n"
                . "Subjek: {$event->ticket->subject}\n"
                . "Aplikasi: {$event->ticket->app?->name}\n"
                . "Prioritas: {$event->ticket->priority}\n\n"
                . 'Ketik /status untuk melihat status tiket Anda.';

            if ($user?->telegramSession) {
                $bot->sendMessage($user->telegramSession->chat_id, $text);
            }
        } catch (\Exception $e) {
            Log::error('Gagal kirim notifikasi tiket dibuat', ['error' => $e->getMessage()]);
        }
    }
}
