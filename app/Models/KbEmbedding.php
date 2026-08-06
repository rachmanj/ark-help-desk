<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KbEmbedding extends Model
{
    protected $fillable = ['article_id', 'content', 'embedding'];

    protected function casts(): array
    {
        return ['embedding' => 'array'];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(KBArticle::class, 'article_id');
    }
}
