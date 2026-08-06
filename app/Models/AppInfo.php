<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    use HasFactory;
    protected $table = 'apps';

    protected $fillable = [
        'name',
        'description',
        'telegram_chat_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class, 'app_id');
    }

    public function kbArticles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KBArticle::class, 'app_id');
    }
}
