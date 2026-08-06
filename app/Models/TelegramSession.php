<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramSession extends Model
{
    protected $table = 'telegram_sessions';

    protected $fillable = [
        'user_id',
        'chat_id',
        'state',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'state' => 'array',
            'last_activity_at' => 'datetime',
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the conversation state.
     * State is stored as JSON: ['status' => '...', ...extra data]
     */
    public function setState(string $status, array $extra = []): void
    {
        $this->state = array_merge($extra, ['status' => $status]);
        $this->last_activity_at = now();
        $this->save();
    }

    /**
     * Get the current status from the state machine.
     */
    public function getStatus(): string
    {
        return $this->state['status'] ?? 'idle';
    }

    /**
     * Check if the session is in a given state.
     */
    public function isInState(string $status): bool
    {
        return $this->getStatus() === $status;
    }

    /**
     * Touch the last_activity_at timestamp.
     */
    public function touchActivity(): void
    {
        $this->last_activity_at = now();
        $this->save();
    }
}
