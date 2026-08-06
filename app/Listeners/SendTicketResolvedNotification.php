<?php

namespace App\Listeners;

use App\Events\TicketResolved;
use App\Services\TelegramBotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendTicketResolvedNotification implements ShouldQueue
{
    public function handle(TicketResolved $event): void
    {
        try {
            $bot = app(TelegramBotService::class);
            $bot->notifyTicketResolved($event->ticket);
        } catch (\Exception $e) {
            Log::error('Gagal kirim notifikasi tiket selesai', ['error' => $e->getMessage()]);
        }
    }
}
