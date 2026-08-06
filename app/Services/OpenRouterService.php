<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    /**
     * Ask the KB — send KB articles + user info to OpenRouter and get an AI reply.
     *
     * @param Ticket $ticket The ticket being processed
     * @param array $kbArticles Array of KBArticle models (top matches)
     * @return array{reply: string, tokens_in: int, tokens_out: int, cost: float}
     *
     * @throws \RuntimeException On API failure
     */
    public function askKB(Ticket $ticket, array $kbArticles): array
    {
        if (! env('AI_ENABLED', true)) {
            throw new \RuntimeException('AI is disabled via AI_ENABLED=false.');
        }

        $apiKey = config('services.openrouter.key');
        if (empty($apiKey) || $apiKey === 'placeholder') {
            throw new \RuntimeException('OPENROUTER_API_KEY belum dikonfigurasi.');
        }

        $model = config('services.openrouter.model', 'openai/gpt-4o-mini');
        $maxTokens = (int) config('services.openrouter.max_tokens', 1024);
        $temperature = (float) config('services.openrouter.temperature', 0.7);

        $appName = $ticket->app?->name ?? 'ARKA HelpDesk';

        // Build KB context
        $kbContext = '';
        if (count($kbArticles) > 0) {
            $kbContext = "📚 <b>Artikel Knowledge Base yang Relevan:</b>\n\n";
            foreach ($kbArticles as $i => $article) {
                $num = $i + 1;
                $kbContext .= "{$num}. <b>{$article->title}</b>\n{$article->content}\n\n";
            }
        }

        $systemPrompt = "Kamu adalah ARKA HelpDesk, bot bantuan untuk {$appName}. "
            . "Tugasmu adalah membantu pengguna menyelesaikan masalah mereka berdasarkan artikel knowledge base yang diberikan. "
            . "Gunakan Bahasa Indonesia yang ramah, jelas, dan profesional. "
            . "Berikan langkah-langkah yang actionable dan spesifik. "
            . "Jika artikel knowledge base tidak cukup untuk menjawab pertanyaan pengguna, "
            . "akui keterbatasanmu dan akhiri dengan 'tidak membantu' agar tiket dieskalasi ke tim support manusia.";

        $userPrompt = "Pengguna mengirimkan pertanyaan berikut:\n\n"
            . "\"{$ticket->subject}\"\n\n"
            . "Deskripsi tambahan: {$ticket->description}\n\n";

        if (count($kbArticles) > 0) {
            $userPrompt .= "Gunakan artikel knowledge base berikut untuk menjawab:\n\n{$kbContext}";
        } else {
            $userPrompt .= "Tidak ada artikel knowledge base yang cocok untuk pertanyaan ini.";
        }

        $userPrompt .= "\nBerikan jawaban yang membantu dan profesional dalam Bahasa Indonesia. "
            . "Jika artikel yang diberikan tidak cukup menyelesaikan masalah atau kamu tidak yakin dengan jawabannya, "
            . "balas 'tidak membantu' dan kami akan eskalasi ke tim support.";

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ];

        Log::info('OpenRouter API call', [
            'ticket_id' => $ticket->id,
            'model' => $model,
            'kb_articles_count' => count($kbArticles),
        ]);

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->withHeaders([
                'HTTP-Referer' => config('app.url', 'http://localhost'),
                'X-Title' => 'ARKA HelpDesk',
            ])
            ->post('https://openrouter.ai/api/v1/chat/completions', $payload);

        if (! $response->successful()) {
            Log::error('OpenRouter API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'ticket_id' => $ticket->id,
            ]);
            throw new \RuntimeException(
                'OpenRouter API error: HTTP ' . $response->status() . ' — ' . $response->body()
            );
        }

        $data = $response->json();

        $reply = $data['choices'][0]['message']['content'] ?? '';
        $tokensIn = $data['usage']['prompt_tokens'] ?? 0;
        $tokensOut = $data['usage']['completion_tokens'] ?? 0;
        $cost = $this->calculateCost($model, $tokensIn, $tokensOut);

        Log::info('OpenRouter API success', [
            'ticket_id' => $ticket->id,
            'tokens_in' => $tokensIn,
            'tokens_out' => $tokensOut,
            'cost' => $cost,
        ]);

        return [
            'reply' => $reply,
            'tokens_in' => $tokensIn,
            'tokens_out' => $tokensOut,
            'model' => $model,
            'cost' => $cost,
        ];
    }

    /**
     * Calculate OpenRouter cost for GPT-4o Mini.
     *
     * Pricing (per 1M tokens):
     *   - Input:  $0.15
     *   - Output: $0.60
     *
     * @param string $model  Model identifier (for future multi-model support)
     * @param int $tokensIn  Prompt tokens used
     * @param int $tokensOut Completion tokens used
     * @return float Cost in USD
     */
    public function calculateCost(string $model, int $tokensIn, int $tokensOut): float
    {
        // gpt-4o-mini pricing via OpenRouter
        $pricePerMillionIn = 0.15;
        $pricePerMillionOut = 0.60;

        // Adjust for other models if needed in the future
        if (str_contains($model, 'gpt-4o')) {
            $pricePerMillionIn = 0.15;
            $pricePerMillionOut = 0.60;
        }

        $cost = ($tokensIn / 1_000_000 * $pricePerMillionIn)
            + ($tokensOut / 1_000_000 * $pricePerMillionOut);

        return round($cost, 8);
    }
}
