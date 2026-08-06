<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'app_id',
        'assigned_to',
        'kb_match_id',
        'subject',
        'description',
        'status',
        'priority',
        'source',
        'metadata',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'resolved_at' => 'datetime',
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function app(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AppInfo::class, 'app_id');
    }

    public function assignedTo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function kbMatch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(KBArticle::class, 'kb_match_id');
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TicketMessage::class)->orderBy('created_at');
    }

    public function aiConversations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AiConversation::class);
    }

    // State machine transitions
    public function canTransitionTo(string $targetStatus): bool
    {
        $allowed = match ($this->status) {
            TicketStatus::Open->value => [
                TicketStatus::AiReplied->value,
                TicketStatus::Escalated->value,
                TicketStatus::Closed->value,
            ],
            TicketStatus::AiReplied->value => [
                TicketStatus::Escalated->value,
                TicketStatus::Closed->value,
            ],
            TicketStatus::Escalated->value => [
                TicketStatus::InProgress->value,
                TicketStatus::Closed->value,
            ],
            TicketStatus::InProgress->value => [
                TicketStatus::Resolved->value,
                TicketStatus::Closed->value,
            ],
            TicketStatus::Resolved->value => [
                TicketStatus::Open->value,
                TicketStatus::Closed->value,
            ],
            default => [],
        };

        return in_array($targetStatus, $allowed);
    }

    public function transitionTo(string $targetStatus): bool
    {
        if (! $this->canTransitionTo($targetStatus)) {
            return false;
        }

        $this->status = $targetStatus;

        if ($targetStatus === TicketStatus::Resolved->value) {
            $this->resolved_at = now();
        }

        if ($targetStatus === TicketStatus::Open->value) {
            $this->resolved_at = null;
        }

        return $this->save();
    }
}
