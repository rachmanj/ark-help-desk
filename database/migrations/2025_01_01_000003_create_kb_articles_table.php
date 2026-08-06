<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kb_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->nullable()->constrained('apps')->nullOnDelete();
            $table->string('title');
            $table->text('content');
            $table->json('tags')->nullable();
            $table->boolean('source_manual')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('helpful_count')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE kb_articles ADD FULLTEXT kb_articles_title_content (title, content)');
    }

    public function down(): void
    {
        Schema::dropIfExists('kb_articles');
    }
};
