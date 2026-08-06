<?php

namespace App\Http\Controllers\Api;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessTicketWithAI;
use App\Models\AppInfo;
use App\Models\TelegramSession;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Services\TelegramBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\Update;

class TelegramWebhookController extends Controller
{
    protected TelegramBotService $bot;

    public function __construct(TelegramBotService $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Handle incoming webhook from Telegram.
     */
    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->all();
            $updateId = $data['update_id'] ?? null;

            // Deduplicate: Telegram may retry webhooks, causing duplicate processing
            if ($updateId && \Illuminate\Support\Facades\Cache::has("tg_update:{$updateId}")) {
                return response()->json(['ok' => true, 'dedup' => true]);
            }
            if ($updateId) {
                \Illuminate\Support\Facades\Cache::put("tg_update:{$updateId}", true, now()->addMinutes(5));
            }

            $update = new Update($data);

            // Handle callback queries (inline button presses)
            if ($update->isType('callback_query')) {
                return $this->handleCallback($update);
            }

            // Handle messages
            if ($update->isType('message') && $update->getMessage()) {
                $message = $update->getMessage();
                $chatId = (string) $message->getChat()->getId();
                $text = $message->getText() ?? '';

                // Get or create Telegram session
                $session = $this->getOrCreateSession($update);

                // Route commands
                if (str_starts_with($text, '/')) {
                    return $this->handleCommand($text, $session, $message);
                }

                // Handle based on conversation state
                return $this->handleStatefulInput($text, $session);
            }

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('Telegram webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['ok' => false, 'error' => 'Internal error'], 500);
        }
    }

    /**
     * Get or create a TelegramSession from the update.
     */
    protected function getOrCreateSession(Update $update): TelegramSession
    {
        $message = $update->getMessage() ?? $update->getCallbackQuery()?->getMessage();
        if (! $message) {
            throw new \RuntimeException('Tidak dapat membaca pesan dari update.');
        }

        $chat = $message->getChat();
        $chatId = (string) $chat->getId();
        $from = $message->getFrom();
        $tgUsername = $from?->getUsername();
        $firstName = $from?->getFirstName() ?? 'User';

        // Match or create user
        $user = User::where('telegram_id', (string) $from?->getId())->first();

        if (! $user) {
            $user = User::create([
                'name' => $firstName . ($from?->getLastName() ? ' ' . $from->getLastName() : ''),
                'email' => 'tg_' . $from->getId() . '@helpdesk.local',
                'password' => bcrypt(bin2hex(random_bytes(16))),
                'role' => 'user',
                'telegram_id' => (string) $from->getId(),
                'telegram_username' => $tgUsername,
            ]);
        }

        // Get or create session
        $session = TelegramSession::where('chat_id', $chatId)->first();

        if (! $session) {
            $session = TelegramSession::create([
                'user_id' => $user->id,
                'chat_id' => $chatId,
                'state' => ['status' => 'idle'],
                'last_activity_at' => now(),
            ]);
        } elseif ($session->user_id !== $user->id) {
            $session->update(['user_id' => $user->id]);
        }

        $session->touchActivity();

        return $session;
    }

    /**
     * Handle slash commands.
     */
    protected function handleCommand(string $text, TelegramSession $session, $message): \Illuminate\Http\JsonResponse
    {
        $chatId = $session->chat_id;
        $parts = explode(' ', trim($text));
        $command = $parts[0];
        $args = array_slice($parts, 1);

        switch ($command) {
            case '/start':
                $this->bot->sendMessage(
                    $chatId,
                    "👋 <b>Halo! Selamat datang di ARKA HelpDesk.</b>\n\n"
                    . "Saya adalah bot bantuan untuk aplikasi-aplikasi Iwan:\n"
                    . "• MineOps\n"
                    . "• Sarang ERP\n"
                    . "• ArkFleet\n"
                    . "• VASIA POS\n"
                    . "• Pratasaba Resort\n\n"
                    . 'Silakan pilih menu di bawah ini. 👇'
                );
                $this->bot->sendMainMenu($chatId);
                $session->setState('idle');
                break;

            case '/ticket':
            case '/new':
                $session->setState('selecting_app');
                $buttons = $this->bot->buildAppSelectionKeyboard();
                $this->bot->sendInlineKeyboard(
                    $chatId,
                    '📱 <b>Pilih Aplikasi</b>\n\nUntuk aplikasi mana Anda ingin membuat tiket?',
                    $buttons,
                    1
                );
                break;

            case '/status':
                $tickets = Ticket::where('user_id', $session->user_id)
                    ->whereNotIn('status', ['closed'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                if ($tickets->isEmpty()) {
                    $this->bot->sendMessage($chatId, '✅ Anda tidak memiliki tiket yang sedang berjalan.');
                } else {
                    $text = "📋 <b>Tiket Anda</b>\n\n";
                    foreach ($tickets as $ticket) {
                        $statusLabel = TicketStatus::from($ticket->status)->label();
                        $text .= "• #{$ticket->id} — {$ticket->subject}\n"
                            . "  Status: {$statusLabel} | {$ticket->app?->name}\n\n";
                    }
                    $this->bot->sendMessage($chatId, $text);
                }
                break;

            case '/apps':
                $apps = AppInfo::where('is_active', true)->get();
                $text = "📱 <b>Daftar Aplikasi</b>\n\n";
                foreach ($apps as $app) {
                    $text .= "• <b>{$app->name}</b>\n";
                }
                $this->bot->sendMessage($chatId, $text);
                break;

            case '/help':
                $this->bot->sendMessage(
                    $chatId,
                    "❓ <b>Bantuan ARKA HelpDesk</b>\n\n"
                    . "/ticket — Buat tiket baru\n"
                    . "/status — Lihat status tiket Anda\n"
                    . "/apps — Lihat daftar aplikasi\n"
                    . "/help — Tampilkan bantuan ini\n\n"
                    . '<b>Admin:</b>\n'
                    . "/resolve #TK-XXX — Selesaikan tiket\n"
                    . "/reopen #TK-XXX — Buka kembali tiket\n"
                    . "/assign #TK-XXX — Ambil alih tiket"
                );
                break;

            case '/resolve':
                $this->handleAdminResolve($chatId, $args);
                break;

            case '/reopen':
                $this->handleAdminReopen($chatId, $args);
                break;

            case '/assign':
                $this->handleAdminAssign($chatId, $args);
                break;

            default:
                $this->bot->sendMessage($chatId, '❓ Perintah tidak dikenal. Ketik /help untuk bantuan.');
                break;
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Handle stateful text input based on conversation state.
     */
    protected function handleStatefulInput(string $text, TelegramSession $session): \Illuminate\Http\JsonResponse
    {
        $state = $session->state['status'] ?? 'idle';
        $chatId = $session->chat_id;

        switch ($state) {
            case 'selecting_app':
                return $this->handleAppNameInput($text, $session);

            case 'describing_issue':
                return $this->handleIssueDescription($text, $session);

            case 'in_conversation':
                return $this->handleConversationReply($text, $session);

            default:
                // Fallback: treat as command-like
                if ($text === '🎫 Buat Tiket') {
                    $session->setState('selecting_app');
                    $this->bot->sendInlineKeyboard(
                        $chatId,
                        '📱 <b>Pilih Aplikasi</b>\n\nUntuk aplikasi mana Anda ingin membuat tiket?',
                        $this->bot->buildAppSelectionKeyboard(),
                        1
                    );
                } elseif ($text === '📋 Tiket Saya') {
                    return $this->handleCommand('/status', $session, null);
                } elseif ($text === '📱 Daftar Aplikasi') {
                    return $this->handleCommand('/apps', $session, null);
                } elseif ($text === '❓ Bantuan') {
                    return $this->handleCommand('/help', $session, null);
                } else {
                    $this->bot->sendMessage(
                        $chatId,
                        'Silakan pilih menu di bawah ini atau ketik /help untuk bantuan.'
                    );
                    $this->bot->sendMainMenu($chatId);
                }
                break;
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Handle inline callback queries (button presses).
     */
    protected function handleCallback(Update $update): \Illuminate\Http\JsonResponse
    {
        $callback = $update->getCallbackQuery();
        $data = $callback->getData();
        $message = $callback->getMessage();
        $chatId = (string) $message->getChat()->getId();

        // Answer the callback to remove loading state
        try {
            $this->bot->bot()->answerCallbackQuery([
                'callback_query_id' => $callback->getId(),
            ]);
        } catch (\Exception $e) {
            // ignore
        }

        $session = $this->getOrCreateSession($update);

        if (str_starts_with($data, 'select_app_')) {
            $appId = (int) str_replace('select_app_', '', $data);
            $app = AppInfo::find($appId);

            if (! $app) {
                $this->bot->sendMessage($chatId, '❌ Aplikasi tidak ditemukan.');
                return response()->json(['ok' => true]);
            }

            $session->setState('describing_issue', [
                'app_id' => $app->id,
                'app_name' => $app->name,
            ]);

            $this->bot->sendMessage(
                $chatId,
                "📝 <b>Deskripsikan Masalah Anda</b>\n\n"
                . "Aplikasi: <b>{$app->name}</b>\n\n"
                . 'Silakan tulis detail masalah yang Anda alami.\n'
                . 'Contoh: "Tidak bisa login setelah update aplikasi"'
            );
        }

        if (str_starts_with($data, 'reply_ticket_')) {
            $ticketId = (int) str_replace('reply_ticket_', '', $data);
            $session->setState('in_conversation', [
                'ticket_id' => $ticketId,
            ]);

            $this->bot->sendMessage(
                $chatId,
                "💬 Silakan tulis balasan Anda untuk tiket #{$ticketId}."
            );
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Handle app name text input.
     */
    protected function handleAppNameInput(string $text, TelegramSession $session): \Illuminate\Http\JsonResponse
    {
        $chatId = $session->chat_id;
        $app = AppInfo::where('name', 'like', "%{$text}%")
            ->where('is_active', true)
            ->first();

        if ($app) {
            $session->setState('describing_issue', [
                'app_id' => $app->id,
                'app_name' => $app->name,
            ]);

            $this->bot->sendMessage(
                $chatId,
                "📝 <b>Deskripsikan Masalah Anda</b>\n\n"
                . "Aplikasi: <b>{$app->name}</b>\n\n"
                . 'Silakan tulis detail masalah yang Anda alami.'
            );
        } else {
            $this->bot->sendMessage(
                $chatId,
                "❌ Aplikasi tidak ditemukan. Gunakan tombol di bawah ini atau ketik nama aplikasi:\n"
                . 'MineOps, Sarang ERP, ArkFleet, VASIA POS, Pratasaba Resort'
            );
            $this->bot->sendInlineKeyboard(
                $chatId,
                'Atau pilih dari daftar:',
                $this->bot->buildAppSelectionKeyboard(),
                1
            );
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Handle the issue description — create a ticket.
     */
    protected function handleIssueDescription(string $text, TelegramSession $session): \Illuminate\Http\JsonResponse
    {
        $chatId = $session->chat_id;
        $data = $session->state;

        $ticket = Ticket::create([
            'user_id' => $session->user_id,
            'app_id' => $data['app_id'],
            'subject' => mb_substr($text, 0, 255),
            'description' => $text,
            'status' => TicketStatus::Open->value,
            'priority' => TicketPriority::Medium->value,
            'source' => 'telegram',
            'metadata' => [
                'chat_id' => $chatId,
                'telegram_username' => $session->user?->telegram_username,
            ],
        ]);

        // Save the first message
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'user',
            'sender_id' => $session->user_id,
            'message' => $text,
        ]);

        // Reset state
        $session->setState('idle');

        // Send confirmation
        $this->bot->sendMessage(
            $chatId,
            "✅ <b>Tiket Berhasil Dibuat!</b>\n\n"
            . "Nomor: #{$ticket->id}\n"
            . "Subjek: {$ticket->subject}\n"
            . "Aplikasi: {$data['app_name']}\n\n"
            . 'Tiket Anda sedang diproses. Kami akan memberitahu Anda jika ada update.'
        );

        // Send AI search indicator
        $this->bot->sendMessage($chatId, '⏳ Mencari jawaban di knowledge base...');

        // Fire event
        event(new \App\Events\TicketCreated($ticket));

        // Dispatch AI processing job
        ProcessTicketWithAI::dispatch($ticket);

        return response()->json(['ok' => true]);
    }

    /**
     * Handle a reply in an active conversation.
     */
    protected function handleConversationReply(string $text, TelegramSession $session): \Illuminate\Http\JsonResponse
    {
        $chatId = $session->chat_id;
        $data = $session->state;
        $ticketId = $data['ticket_id'] ?? null;

        if (! $ticketId) {
            $session->setState('idle');
            $this->bot->sendMessage($chatId, '❌ Sesi telah berakhir. Gunakan /ticket untuk membuat tiket baru.');

            return response()->json(['ok' => true]);
        }

        $ticket = Ticket::find($ticketId);
        if (! $ticket) {
            $session->setState('idle');
            $this->bot->sendMessage($chatId, '❌ Tiket tidak ditemukan.');

            return response()->json(['ok' => true]);
        }

        // Save the message
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'user',
            'sender_id' => $session->user_id,
            'message' => $text,
        ]);

        // Forward to admin if ticket is escalated/in-progress
        if (in_array($ticket->status, ['escalated', 'in_progress'])) {
            $adminMsg = "💬 <b>Balasan dari Pelanggan</b>\n\n"
                . "Tiket: #{$ticket->id}\n"
                . "Pengguna: {$session->user?->name}\n\n"
                . "<i>{$text}</i>";

            $adminId = config('telegram.admin_id');
            if ($adminId) {
                $this->bot->sendMessage($adminId, $adminMsg);
            }
        }

        $this->bot->sendMessage(
            $chatId,
            '✅ Balasan Anda telah dikirim. Tim support akan segera merespons.'
        );

        return response()->json(['ok' => true]);
    }

    // ─── Admin Commands ──────────────────────────────────────────

    protected function handleAdminResolve(string $chatId, array $args): void
    {
        if (! $this->isAdmin($chatId)) {
            $this->bot->sendMessage($chatId, '⛔ Perintah ini hanya untuk admin.');
            return;
        }

        $ticketId = $this->parseTicketArg($args);
        if (! $ticketId) {
            $this->bot->sendMessage($chatId, '❌ Format: /resolve #TK-XXXX');
            return;
        }

        $ticket = Ticket::find($ticketId);
        if (! $ticket) {
            $this->bot->sendMessage($chatId, '❌ Tiket tidak ditemukan.');
            return;
        }

        $ticket->transitionTo(TicketStatus::Resolved->value);

        $this->bot->sendMessage($chatId, "✅ Tiket #{$ticket->id} telah diselesaikan.");

        event(new \App\Events\TicketResolved($ticket));
    }

    protected function handleAdminReopen(string $chatId, array $args): void
    {
        if (! $this->isAdmin($chatId)) {
            $this->bot->sendMessage($chatId, '⛔ Perintah ini hanya untuk admin.');
            return;
        }

        $ticketId = $this->parseTicketArg($args);
        if (! $ticketId) {
            $this->bot->sendMessage($chatId, '❌ Format: /reopen #TK-XXXX');
            return;
        }

        $ticket = Ticket::find($ticketId);
        if (! $ticket) {
            $this->bot->sendMessage($chatId, '❌ Tiket tidak ditemukan.');
            return;
        }

        $ticket->transitionTo(TicketStatus::Open->value);

        $this->bot->sendMessage($chatId, "🔄 Tiket #{$ticket->id} telah dibuka kembali.");
    }

    protected function handleAdminAssign(string $chatId, array $args): void
    {
        if (! $this->isAdmin($chatId)) {
            $this->bot->sendMessage($chatId, '⛔ Perintah ini hanya untuk admin.');
            return;
        }

        $ticketId = $this->parseTicketArg($args);
        if (! $ticketId) {
            $this->bot->sendMessage($chatId, '❌ Format: /assign #TK-XXXX');
            return;
        }

        $ticket = Ticket::find($ticketId);
        if (! $ticket) {
            $this->bot->sendMessage($chatId, '❌ Tiket tidak ditemukan.');
            return;
        }

        $admin = User::where('telegram_id', (string) $chatId)
            ->orWhere('chat_id', $chatId)
            ->first();

        // Find admin by telegram session
        if (! $admin) {
            $tgSession = TelegramSession::where('chat_id', $chatId)->first();
            if ($tgSession) {
                $admin = $tgSession->user;
            }
        }

        $ticket->assigned_to = $admin?->id;
        $ticket->transitionTo(TicketStatus::InProgress->value);

        $adminName = $admin?->name ?? 'Admin';

        $this->bot->sendMessage($chatId, "📌 Tiket #{$ticket->id} telah ditugaskan ke {$adminName}.");
    }

    /**
     * Parse ticket number from args, supporting formats: #123, #TK-123, or just 123.
     */
    protected function parseTicketArg(array $args): ?int
    {
        if (empty($args)) {
            return null;
        }

        $raw = $args[0];
        // Strip # and TK- prefix
        $cleaned = preg_replace('/^#?(?:TK-)?/i', '', $raw);

        return is_numeric($cleaned) ? (int) $cleaned : null;
    }

    /**
     * Dashboard reply — called from the web UI when admin replies to a Telegram ticket.
     */
    public function dashboardReply(Request $request, Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:4096',
        ]);

        // Save admin message
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'admin',
            'sender_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        // Send via Telegram bot to the user
        if ($ticket->source === 'telegram') {
            $tgSession = TelegramSession::where('user_id', $ticket->user_id)->first();
            if ($tgSession) {
                $adminName = auth()->user()->name ?? 'Admin';
                $text = "💬 <b>Balasan dari {$adminName}</b>\n\n"
                    . "Tiket: #{$ticket->id} — {$ticket->subject}\n\n"
                    . "<i>{$validated['message']}</i>\n\n"
                    . 'Balas pesan ini untuk melanjutkan percakapan.';

                $this->bot->sendMessage($tgSession->chat_id, $text);
            }
        }

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    /**
     * Check if the chatId belongs to an admin.
     */
    protected function isAdmin(string $chatId): bool
    {
        $adminId = config('telegram.admin_id');
        if ($chatId === $adminId) {
            return true;
        }

        // Also check if the chat belongs to an admin user
        $session = TelegramSession::where('chat_id', $chatId)->first();
        if ($session && $session->user && $session->user->isAdmin()) {
            return true;
        }

        return false;
    }
}
