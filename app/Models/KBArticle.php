<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KBArticle extends Model
{
    protected $table = 'kb_articles';

    protected $fillable = [
        'app_id',
        'title',
        'content',
        'tags',
        'source_manual',
        'is_published',
        'view_count',
        'helpful_count',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'source_manual' => 'boolean',
            'is_published' => 'boolean',
            'view_count' => 'integer',
            'helpful_count' => 'integer',
        ];
    }

    public function app(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AppInfo::class, 'app_id');
    }

    public function links(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KBArticleLink::class, 'article_id');
    }

    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class, 'kb_match_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeSearch($query, string $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->whereRaw(
            "MATCH(title, content) AGAINST(? IN BOOLEAN MODE)",
            [$term]
        )->orderByRaw(
            'MATCH(title, content) AGAINST(?) DESC',
            [$term]
        );
    }
}
