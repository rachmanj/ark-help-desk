<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KBArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [];

        // Flat files (articles already have app_id)
        foreach (['mineops', 'sarang_erp'] as $name) {
            $data = require __DIR__ . "/articles/{$name}.php";
            $articles = array_merge($articles, $data);
        }

        // Nested file: keyed by app_id, articles missing app_id
        $nested = require __DIR__ . '/articles/other_apps.php';
        foreach ($nested as $appId => $appArticles) {
            foreach ($appArticles as $article) {
                $article['app_id'] = $appId;
                $articles[] = $article;
            }
        }

        // Insert in chunks
        foreach (array_chunk($articles, 20) as $chunk) {
            DB::table('kb_articles')->insert($chunk);
        }

        $this->command->info('Seeded ' . count($articles) . ' KB articles.');
    }
}
