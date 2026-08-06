<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KBArticleLink extends Model
{
    protected $table = 'kb_article_links';

    protected $fillable = [
        'article_id',
        'related_article_id',
        'link_type',
    ];

    public function article(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(KBArticle::class, 'article_id');
    }

    public function relatedArticle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(KBArticle::class, 'related_article_id');
    }
}
