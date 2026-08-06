<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;

class TelegramBotService
{
    protected ?Api $telegram = null;

    public function bot(): Api
    {
        if (! $this->telegram) {
            $token = config('telegram.bot_token');
            if (empty($token) || $token === 'placeholder') {
                throw new \RuntimeException('TELEGRAM_BOT_TOKEN belum dikonfigurasi.');
            }
            $this->telegram = new Api($token);
        }

        return $this->telegram;
    }

    /**
     * Send a text message to a chat.
     */
    public function sendMessage(string $chatId, string $text, ?array $keyboard = null, string $parseMode = 'HTML'): ?array
    {
        try {
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => $parseMode,
            ];

            if ($keyboard) {
                $params['reply_markup'] = json_encode($keyboard);
            }

            return $this->bot()->sendMessage($params);
        } catch (TelegramSDKException $e) {
            Log::error('Telegram sendMessage gagal', [
                'chat_id' => $chatId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Send an inline keyboard message.
     */
    public function sendInlineKeyboard(string $chatId, string $text, array $buttons, int $columns = 2): ?array
    {
        $inlineKeyboard = [];

        foreach (array_chunk($buttons, $columns) as $row) {
            $inlineKeyboard[] = array_map(function ($btn) {
                if (isset($btn['url'])) {
                    return Keyboard::inlineButton([
                        'text' => $btn['text'],
                        'url' => $btn['url'],
                    ]);
                }

                return Keyboard::inlineButton([
                    'text' => $btn['text'],
                    'callback_data' => $btn['callback_data'] ?? $btn['text'],
                ]);
            }, $row);
        }

        return $this->sendMessage($chatId, $text, [
            'inline_keyboard' => $inlineKeyboard,
        ]);
    }

    /**
     * Get updates (for setup/setWebhook).
     */
    public function getUpdates(): array
    {
        try {
            return $this->bot()->getUpdates();
        } catch (TelegramSDKException $e) {
            Log::error('Telegram getUpdates gagal', ['error' => $e->getMessage()]);

            return [];
        }
    }

    /**
     * Set the webhook URL.
     */
    public function setWebhook(string $url, string $secretToken): bool
    {
        try {
            $result = $this->bot()->setWebhook([
                'url' => $url,
                'secret_token' => $secretToken,
            ]);

            return $result;
        } catch (TelegramSDKException $e) {
            Log::error('Telegram setWebhook gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Forward a message to the admin (Iwan).
     */
    public function forwardToAdmin(string $text, ?array $keyboard = null): ?array
    {
        $adminId = config('telegram.admin_id');

        if (empty($adminId)) {
            Log::warning('TELEGRAM_ADMIN_ID belum dikonfigurasi — pesan tidak dapat dikirim ke admin.');

            return null;
        }

        return $this->sendMessage($adminId, $text, $keyboard);
    }

    /**
     * Notify a user via Telegram.
     */
    public function notifyUser(int $userId, string $text): ?array
    {
        $user = User::find($userId);
        if (! $user || ! $user->telegramSession || ! $user->telegramSession->chat_id) {
            Log::warning('Tidak dapat mengirim notifikasi ke user', ['user_id' => $userId]);

            return null;
        }

        return $this->sendMessage($user->telegramSession->chat_id, $text);
    }

    /**
     * Notify user about ticket resolution.
     */
    public function notifyTicketResolved(Ticket $ticket): ?array
    {
        $text = "✅ <b>Tiket #{$ticket->id} Telah Diselesaikan</b>\n\n"
            . "Subjek: {$ticket->subject}\n"
            . "Status: Terselesaikan\n\n"
            . 'Terima kasih telah menggunakan ARKA HelpDesk! 🙏';

        return $this->notifyUser($ticket->user_id, $text);
    }

    /**
     * Build app selection inline keyboard.
     */
    public function buildAppSelectionKeyboard(): array
    {
        $apps = \App\Models\AppInfo::where('is_active', true)->get();
        $buttons = [];

        foreach ($apps as $app) {
            $buttons[] = [
                'text' => $app->name,
                'callback_data' => "select_app_{$app->id}",
            ];
        }

        return $buttons;
    }

    /**
     * Build main menu keyboard.
     */
    public function sendMainMenu(string $chatId): ?array
    {
        $text = "🏢 <b>ARKA HelpDesk</b>\n\n"
            . 'Selamat datang di ARKA HelpDesk! Silakan pilih menu di bawah ini:';

        $keyboard = [
            'keyboard' => [
                [['text' => '🎫 Buat Tiket'], ['text' => '📋 Tiket Saya']],
                [['text' => '📱 Daftar Aplikasi'], ['text' => '❓ Bantuan']],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
        ];

        return $this->sendMessage($chatId, $text, $keyboard);
    }
}
