<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'open';
    case AiReplied = 'ai_replied';
    case Escalated = 'escalated';
    case InProgress = 'in_progress';
    case Resolved = 'resolved';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Terbuka',
            self::AiReplied => 'Dibalas AI',
            self::Escalated => 'Dieskalasi',
            self::InProgress => 'Dalam Proses',
            self::Resolved => 'Terselesaikan',
            self::Closed => 'Ditutup',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Open => 'blue',
            self::AiReplied => 'cyan',
            self::Escalated => 'orange',
            self::InProgress => 'processing',
            self::Resolved => 'green',
            self::Closed => 'default',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
