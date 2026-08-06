<?php

namespace App\Services;

use App\Models\KbEmbedding;
use Illuminate\Support\Facades\Http;

class KbEmbeddingService
{
    private const OPENROUTER_URL = 'https://openrouter.ai/api/v1/embeddings';

    public function __construct(
        private ?string $apiKey = null,
        private string $siteUrl = 'http://localhost',
    ) {
        $this->apiKey ??= env('OPENROUTER_API_KEY') ?: config('services.ai.key');
    }

    /**
     * Generate embedding vectors for a list of texts.
     * @return list<array<int, float>>
     */
    public function createEmbeddings(array $texts): array
    {
        $model = 'openai/text-embedding-3-small';

        $response = Http::timeout(120)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => $this->siteUrl,
                'Content-Type' => 'application/json',
            ])
            ->post(self::OPENROUTER_URL, [
                'model' => $model,
                'input' => $texts,
            ]);

        if (!$response->successful()) {
            throw new \RuntimeException('Embedding API error: HTTP ' . $response->status());
        }

        $data = $response->json();
        $out = [];
        foreach ($data['data'] as $item) {
            $out[] = array_values($item['embedding']);
        }

        return $out;
    }

    /**
     * Search KB articles by semantic similarity.
     * @return array{articles: array, top_score: float}
     */
    public function search(string $query, int $topK = 5): array
    {
        $embeddings = KbEmbedding::with('article')->get();

        if ($embeddings->isEmpty()) {
            return ['articles' => [], 'top_score' => 0.0];
        }

        $queryVectors = $this->createEmbeddings([trim($query)]);
        $queryEmbedding = $queryVectors[0] ?? [];

        if (empty($queryEmbedding)) {
            return ['articles' => [], 'top_score' => 0.0];
        }

        $scored = [];
        foreach ($embeddings as $row) {
            $emb = $row->embedding;
            $score = self::cosineSimilarity($queryEmbedding, $emb);
            $scored[] = ['row' => $row, 'score' => $score];
        }

        usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);
        $top = array_slice($scored, 0, $topK);

        $articles = [];
        foreach ($top as $item) {
            $articles[] = [
                'article' => $item['row']->article,
                'score' => $item['score'],
                'content' => $item['row']->content,
            ];
        }

        return [
            'articles' => $articles,
            'top_score' => $top[0]['score'] ?? 0.0,
        ];
    }

    public static function cosineSimilarity(array $a, array $b): float
    {
        $n = min(count($a), count($b));
        if ($n === 0) return 0.0;

        $dot = 0.0; $na = 0.0; $nb = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $dot += $a[$i] * $b[$i];
            $na += $a[$i] * $a[$i];
            $nb += $b[$i] * $b[$i];
        }

        $den = sqrt($na) * sqrt($nb);
        return $den > 0.0 ? $dot / $den : 0.0;
    }
}
