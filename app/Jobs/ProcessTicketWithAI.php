<?php

namespace App\Jobs;

use App\Enums\TicketStatus;
use App\Models\AiConversation;
use App\Models\KBArticle;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Services\OpenRouterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessTicketWithAI implements ShouldQueue
{
    use Queueable;

    /**
     * Retry config: 3 attempts with exponential backoff.
     * On final failure, escalate with note "AI tidak tersedia".
     */
    public int $tries = 3;

    public function __construct(public Ticket $ticket)
    {
        //
    }

    /**
     * Calculate the backoff for retries.
     * Attempt 1: 30s, Attempt 2: 60s, Attempt 3: 120s
     */
    public function backoff(): array
    {
        return [30, 60, 120];
    }

    /**
     * Execute the job.
     */
    public function handle(OpenRouterService $openRouter): void
    {
        Log::info('ProcessTicketWithAI — mulai memproses', [
            'ticket_id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
        ]);

        // 1. FULLTEXT search on KB articles for this app
        $searchTerm = $this->ticket->subject . ' ' . $this->ticket->description;

        $kbArticles = KBArticle::query()
            ->where('app_id', $this->ticket->app_id)
            ->where('is_published', true)
            ->whereRaw(
                'MATCH(title, content) AGAINST(? IN BOOLEAN MODE)',
                [$searchTerm]
            )
            ->selectRaw(
                '*, MATCH(title, content) AGAINST(?) AS relevance',
                [$searchTerm]
            )
            ->orderByDesc('relevance')
            ->limit(3)
            ->get();

        $topScore = $kbArticles->first()?->relevance ?? 0;
        $threshold = (float) env('AI_CONFIDENCE_THRESHOLD', 0.6);

        Log::info('ProcessTicketWithAI — hasil pencarian KB', [
            'ticket_id' => $this->ticket->id,
            'articles_found' => $kbArticles->count(),
            'top_score' => $topScore,
            'threshold' => $threshold,
        ]);

        // 2. Check if top score meets confidence threshold
        if ($topScore >= $threshold && $kbArticles->isNotEmpty()) {
            // Enough confidence — call AI
            $this->generateAiReply($openRouter, $kbArticles);
        } else {
            // Low confidence — escalate
            $this->escalateTicket('KB confidence rendah — skor tertinggi ' . number_format($topScore, 4) . ' < threshold ' . $threshold);
        }
    }

    /**
     * Generate AI reply via OpenRouter and save it.
     */
    protected function generateAiReply(OpenRouterService $openRouter, $kbArticles): void
    {
        try {
            $result = $openRouter->askKB($this->ticket, $kbArticles->all());

            $reply = trim($result['reply']);

            // Check if AI indicated it cannot help
            if (stripos($reply, 'tidak membantu') !== false || empty($reply)) {
                Log::info('ProcessTicketWithAI — AI tidak dapat membantu, eskalasi', [
                    'ticket_id' => $this->ticket->id,
                    'reply_preview' => mb_substr($reply, 0, 100),
                ]);

                // Still save the AI attempt as a message
                TicketMessage::create([
                    'ticket_id' => $this->ticket->id,
                    'sender_type' => 'ai',
                    'sender_id' => null,
                    'message' => $reply ?: 'Maaf, saya tidak dapat menemukan jawaban untuk pertanyaan Anda.',
                    'is_ai_generated' => true,
                ]);

                $this->escalateTicket('AI tidak dapat menyelesaikan — lihat pesan AI di atas.');
                return;
            }

            // 3. Save AI response as ticket_message
            TicketMessage::create([
                'ticket_id' => $this->ticket->id,
                'sender_type' => 'ai',
                'sender_id' => null,
                'message' => $reply,
                'is_ai_generated' => true,
                'kb_article_id' => $kbArticles->first()?->id,
            ]);

            // 4. Save ai_conversations row
            AiConversation::create([
                'ticket_id' => $this->ticket->id,
                'prompt' => [
                    'subject' => $this->ticket->subject,
                    'description' => $this->ticket->description,
                    'kb_articles' => $kbArticles->pluck('id')->toArray(),
                ],
                'response' => $reply,
                'tokens_used' => ($result['tokens_in'] ?? 0) + ($result['tokens_out'] ?? 0),
                'model' => $result['model'] ?? config('services.ai.model'),
                'cost' => $result['cost'] ?? 0,
            ]);

            // 5. Update ticket status
            $this->ticket->transitionTo(TicketStatus::AiReplied->value);

            Log::info('ProcessTicketWithAI — tiket dibalas AI', [
                'ticket_id' => $this->ticket->id,
                'reply_length' => mb_strlen($reply),
                'cost' => $result['cost'] ?? 0,
            ]);
        } catch (\Exception $e) {
            Log::error('ProcessTicketWithAI — gagal generate AI reply', [
                'ticket_id' => $this->ticket->id,
                'error' => $e->getMessage(),
            ]);

            // Escalate on API failure (retries will handle transient failures)
            $this->escalateTicket('Gagal menghasilkan balasan AI: ' . $e->getMessage());
        }
    }

    /**
     * Escalate the ticket to admin.
     */
    protected function escalateTicket(string $reason): void
    {
        $this->ticket->transitionTo(TicketStatus::Escalated->value);

        // Save escalation note
        TicketMessage::create([
            'ticket_id' => $this->ticket->id,
            'sender_type' => 'ai',
            'sender_id' => null,
            'message' => '⚠️ Tiket ini telah dieskalasi ke tim support. ' . $reason,
            'is_ai_generated' => true,
        ]);

        // Fire escalated event
        event(new \App\Events\TicketEscalated($this->ticket));

        Log::info('ProcessTicketWithAI — tiket dieskalasi', [
            'ticket_id' => $this->ticket->id,
            'reason' => $reason,
        ]);
    }

    /**
     * Handle a job failure (runs after all retries exhausted).
     */
    public function failed(?\Throwable $exception = null): void
    {
        Log::error('ProcessTicketWithAI — final failure after retries', [
            'ticket_id' => $this->ticket->id,
            'error' => $exception?->getMessage(),
        ]);

        // Refresh ticket from DB in case of changes
        $this->ticket->refresh();

        // Only escalate if not already escalated or closed
        if (! in_array($this->ticket->status, [
            TicketStatus::Escalated->value,
            TicketStatus::Closed->value,
            TicketStatus::Resolved->value,
        ])) {
            $this->ticket->transitionTo(TicketStatus::Escalated->value);

            TicketMessage::create([
                'ticket_id' => $this->ticket->id,
                'sender_type' => 'ai',
                'sender_id' => null,
                'message' => '❌ AI tidak tersedia saat ini. Tiket telah dieskalasi ke tim support. Mohon tunggu, tim kami akan segera merespons.',
                'is_ai_generated' => true,
            ]);

            event(new \App\Events\TicketEscalated($this->ticket));
        }
    }
}
