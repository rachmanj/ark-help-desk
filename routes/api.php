<?php

use App\Http\Controllers\Api\TelegramWebhookController;
use Illuminate\Support\Facades\Route;

// ─── Telegram Webhook ────────────────────────────────────────────
// No CSRF protection (validated via X-Telegram-Bot-Api-Secret-Token header)
Route::post('/telegram/webhook', [TelegramWebhookController::class, 'handle'])
    ->middleware('telegram.secret')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('api.telegram.webhook');

// ─── Ticket reply from web dashboard via Telegram bot ────────────
// Used by Tickets/Show.jsx reply form when ticket.source=telegram
Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::post('/telegram/reply/{ticket}', [TelegramWebhookController::class, 'dashboardReply'])
        ->name('api.telegram.reply');
});
