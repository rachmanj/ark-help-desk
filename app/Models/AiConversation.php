<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiConversation extends Model
{
    protected $table = 'ai_conversations';

    protected $fillable = [
        'ticket_id',
        'prompt',
        'response',
        'tokens_used',
        'model',
        'cost',
    ];

    protected function casts(): array
    {
        return [
            'prompt' => 'array',
            'tokens_used' => 'integer',
            'cost' => 'decimal:8',
        ];
    }

    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
