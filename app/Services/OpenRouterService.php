<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    /**
     * Ask the KB — send KB articles + user info to AI provider and get a reply.
     *
     * Supports: OpenRouter, DeepSeek (OpenAI-compatible)
     */
    public function askKB(Ticket $ticket, array $kbArticles): array
    {
        if (! env('AI_ENABLED', true)) {
            throw new \RuntimeException('AI is disabled via AI_ENABLED=false.');
        }

        $provider = config('services.ai.provider', 'openrouter');
        $apiKey = config('services.ai.key');
        $model = config('services.ai.model', 'deepseek-chat');
        $maxTokens = (int) config('services.ai.max_tokens', 1024);
        $temperature = (float) config('services.ai.temperature', 0.7);

        if (empty($apiKey) || $apiKey === 'placeholder') {
            throw new \RuntimeException('AI_API_KEY belum dikonfigurasi.');
        }

        $endpoint = match ($provider) {
            'deepseek' => 'https://api.deepseek.com/v1/chat/completions',
            default => 'https://openrouter.ai/api/v1/chat/completions',
        };

        $appName = $ticket->app?->name ?? 'ARKA HelpDesk';

        // Build system + user prompt (Sarang ERP style — assertive, context-bound)
        $systemPrompt = "Kamu adalah ARKA HelpDesk, bot bantuan dalam aplikasi untuk {$appName}. "
            . "Jawab HANYA menggunakan KONTEKS yang diberikan di bawah ini. "
            . "Lingkup: langkah-langkah how-to dan di mana menemukan fitur di aplikasi ini. "
            . "Gunakan Bahasa Indonesia yang ramah, jelas, dan profesional. "
            . "Berikan langkah-langkah actionable dengan nomor urut. "
            . "Jika KONTEKS tidak mengandung cukup detail untuk menjawab, katakan dengan singkat bahwa hal tersebut belum terdokumentasi "
            . "dan akhiri dengan baris terpisah berisi [ESCALATE]. "
            . "JANGAN mengarang menu, tombol, atau nama field yang tidak disebutkan dalam KONTEKS.";

        $kbContext = '';
        if (count($kbArticles) > 0) {
            $kbContext = "📚 Artikel Knowledge Base yang Relevan:\n\n";
            foreach ($kbArticles as $i => $article) {
                $num = $i + 1;
                $kbContext .= "{$num}. {$article->title}\n{$article->content}\n\n";
            }
        }

        $userPrompt = "KONTEKS (dokumentasi {$appName} — jangan mengarang di luar ini):\\n\\n{$kbContext}\\n\\n"
            . "PERTANYAAN PENGGUNA:\\n"
            . "\"{$ticket->subject}\"\\n\\n"
            . "Deskripsi tambahan: {$ticket->description}";

        if (count($kbArticles) === 0) {
            $userPrompt = "PERTANYAAN PENGGUNA:\\n\"{$ticket->subject}\"\\n\\nDeskripsi: {$ticket->description}\\n\\n"
                . "(Tidak ada KONTEKS dokumentasi yang cocok — jika tidak bisa menjawab, balas dengan [ESCALATE])";
        }

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ];

        Log::info('AI API call', [
            'ticket_id' => $ticket->id,
            'provider' => $provider,
            'model' => $model,
            'kb_articles_count' => count($kbArticles),
        ]);

        $http = Http::withToken($apiKey)->timeout(60);

        // OpenRouter-specific headers
        if ($provider === 'openrouter') {
            $http->withHeaders([
                'HTTP-Referer' => config('app.url', 'http://localhost'),
                'X-Title' => 'ARKA HelpDesk',
            ]);
        }

        $response = $http->post($endpoint, $payload);

        if (! $response->successful()) {
            Log::error('AI API error', [
                'provider' => $provider,
                'status' => $response->status(),
                'body' => $response->body(),
                'ticket_id' => $ticket->id,
            ]);
            throw new \RuntimeException(
                "AI API error ({$provider}): HTTP {$response->status()}"
            );
        }

        $data = $response->json();

        $reply = $data['choices'][0]['message']['content'] ?? '';
        $tokensIn = $data['usage']['prompt_tokens'] ?? 0;
        $tokensOut = $data['usage']['completion_tokens'] ?? 0;
        $cost = $this->calculateCost($provider, $model, $tokensIn, $tokensOut);

        Log::info('AI API success', [
            'ticket_id' => $ticket->id,
            'provider' => $provider,
            'model' => $model,
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
     * Calculate cost based on provider and model.
     *
     * Pricing per 1M tokens:
     *   DeepSeek V3: $0.27 input / $1.10 output
     *   GPT-4o Mini (OpenRouter): $0.15 input / $0.60 output
     */
    public function calculateCost(string $provider, string $model, int $tokensIn, int $tokensOut): float
    {
        $pricing = match ($provider) {
            'deepseek' => ['in' => 0.27, 'out' => 1.10],
            default => ['in' => 0.15, 'out' => 0.60],
        };

        $cost = ($tokensIn / 1_000_000 * $pricing['in'])
            + ($tokensOut / 1_000_000 * $pricing['out']);

        return round($cost, 8);
    }
}
