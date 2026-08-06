<?php

namespace App\Console\Commands;

use App\Models\KBArticle;
use App\Models\KbEmbedding;
use App\Services\KbEmbeddingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class KbReindexCommand extends Command
{
    protected $signature = 'kb:reindex {--batch=6 : Articles per API call}';
    protected $description = 'Rebuild KB embeddings from kb_articles for semantic search';

    public function handle(KbEmbeddingService $service): int
    {
        $articles = KBArticle::where('is_published', true)->get();

        if ($articles->isEmpty()) {
            $this->warn('No published KB articles found.');
            return self::FAILURE;
        }

        $this->info("Embedding {$articles->count()} articles...");

        DB::table('kb_embeddings')->truncate();
        $bar = $this->output->createProgressBar($articles->count());
        $bar->start();

        $batchSize = (int) $this->option('batch');
        $chunks = $articles->chunk($batchSize);

        foreach ($chunks as $chunk) {
            $texts = $chunk->map(fn($a) => mb_substr($a->title . "\n\n" . $a->content, 0, 8000))->values()->all();
            $vectors = $service->createEmbeddings($texts);

            $chunkValues = $chunk->values();
            foreach ($chunkValues as $i => $article) {
                KbEmbedding::create([
                    'article_id' => $article->id,
                    'content' => $texts[$i],
                    'embedding' => $vectors[$i] ?? [],
                ]);
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Done! {$articles->count()} embeddings created.");

        return self::SUCCESS;
    }
}
