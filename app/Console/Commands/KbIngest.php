<?php

namespace App\Console\Commands;

use App\Models\AppInfo;
use App\Models\KBArticle;
use Illuminate\Console\Command;
use Smalot\PdfParser\Parser;

class KbIngest extends Command
{
    protected $signature = 'kb:ingest
                            {file : Path to the PDF file to ingest}
                            {--app= : App slug or ID to associate articles with}';

    protected $description = 'Ingest a PDF document and split it into KB articles';

    public function handle(): int
    {
        $filePath = $this->argument('file');
        $appOption = $this->option('app');

        if (! file_exists($filePath)) {
            $this->error("File not found: {$filePath}");

            return self::FAILURE;
        }

        // Resolve app
        $app = null;
        if ($appOption) {
            $app = AppInfo::where('name', $appOption)
                ->orWhere('id', $appOption)
                ->first();

            if (! $app) {
                $this->error("App not found: {$appOption}");

                return self::FAILURE;
            }
        }

        $this->info("Parsing PDF: {$filePath}");

        try {
            $parser = new Parser;
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();
        } catch (\Exception $e) {
            $this->error('Failed to parse PDF: '.$e->getMessage());

            return self::FAILURE;
        }

        if (empty(trim($text))) {
            $this->error('PDF contains no extractable text. It may be a scanned document.');

            return self::FAILURE;
        }

        $this->info('PDF parsed successfully. Splitting into articles...');

        $articles = $this->splitIntoArticles($text);
        $count = 0;

        foreach ($articles as $article) {
            if (empty(trim($article['title'])) || empty(trim($article['content']))) {
                continue;
            }

            KBArticle::create([
                'app_id' => $app?->id,
                'title' => $article['title'],
                'content' => $article['content'],
                'tags' => $article['tags'] ?? [],
                'source_manual' => true,
                'is_published' => true,
            ]);

            $count++;
            $this->line("  ✓ {$article['title']}");
        }

        $this->info("Done! Created {$count} KB articles.");

        return self::SUCCESS;
    }

    /**
     * Split raw PDF text into articles using heading detection.
     * Detects headings (ALL CAPS lines, lines ending with colon, or Markdown-style ## headers)
     * and groups subsequent paragraphs under them.
     */
    private function splitIntoArticles(string $text): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)));
        $articles = [];
        $currentTitle = 'Untitled Section';
        $currentContent = [];
        $currentTags = [];

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            // Detect headings: ALL CAPS (min 3 chars), Markdown ## headers, or lines ending with colon
            $isHeading = false;

            // ALL CAPS heading (at least 3 chars, not entirely punctuation)
            if (strtoupper($line) === $line && strlen($line) >= 3 && preg_match('/[A-Z]/', $line)) {
                $isHeading = true;
            }

            // Markdown-style heading
            if (preg_match('/^#{1,3}\s+(.+)/', $line, $m)) {
                $line = $m[1];
                $isHeading = true;
            }

            // Line ending with colon (likely a heading/section title)
            if (preg_match('/^.{3,60}:$/', $line)) {
                $isHeading = true;
            }

            // Numbered sections like "1. Introduction" or "SECTION 1:"
            if (preg_match('/^(?:Section\s+\d+|Chapter\s+\d+|\d+\.)\s+.+/i', $line)) {
                $isHeading = true;
            }

            if ($isHeading) {
                // Save previous article
                if (! empty($currentContent)) {
                    $articles[] = [
                        'title' => $currentTitle,
                        'content' => implode("\n\n", $currentContent),
                        'tags' => $currentTags,
                    ];
                }

                $currentTitle = $this->cleanTitle($line);
                $currentContent = [];
                $currentTags = [];
            } else {
                $currentContent[] = $line;
            }
        }

        // Save last article
        if (! empty($currentContent)) {
            $articles[] = [
                'title' => $currentTitle,
                'content' => implode("\n\n", $currentContent),
                'tags' => $currentTags,
            ];
        }

        // If only one block was found, split by double-newline into smaller articles
        if (count($articles) <= 1 && ! empty($articles)) {
            return $this->splitByParagraphs($text);
        }

        return $articles;
    }

    /**
     * Fallback: split text by paragraphs when no headings detected.
     */
    private function splitByParagraphs(string $text): array
    {
        $paragraphs = array_filter(array_map('trim', explode("\n\n", $text)));
        $articles = [];
        $chunkSize = max(3, (int) ceil(count($paragraphs) / 10)); // aim for ~10 articles
        $chunks = array_chunk($paragraphs, $chunkSize);

        foreach ($chunks as $i => $chunk) {
            $content = implode("\n\n", $chunk);
            $title = $this->generateTitle($content, $i + 1);

            $articles[] = [
                'title' => $title,
                'content' => $content,
                'tags' => [],
            ];
        }

        return $articles;
    }

    private function cleanTitle(string $title): string
    {
        // Remove leading markers like ##, numbers, etc.
        $title = preg_replace('/^#{1,3}\s*/', '', $title);
        $title = preg_replace('/^\d+\.\s*/', '', $title);
        // Remove trailing colon
        $title = rtrim($title, ':');
        // Limit length
        if (strlen($title) > 200) {
            $title = substr($title, 0, 197).'...';
        }

        return trim($title);
    }

    private function generateTitle(string $content, int $index): string
    {
        // Take first sentence or first 80 chars as title
        $firstLine = explode("\n", $content)[0];
        if (strlen($firstLine) > 80) {
            $firstLine = substr($firstLine, 0, 77).'...';
        }

        return "Section {$index}: {$firstLine}";
    }
}
