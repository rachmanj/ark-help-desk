<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'open' => Ticket::where('status', TicketStatus::Open->value)->count(),
            'ai_replied' => Ticket::where('status', TicketStatus::AiReplied->value)->count(),
            'escalated' => Ticket::where('status', TicketStatus::Escalated->value)->count(),
            'in_progress' => Ticket::where('status', TicketStatus::InProgress->value)->count(),
            'resolved_today' => Ticket::where('status', TicketStatus::Resolved->value)
                ->whereDate('resolved_at', today())
                ->count(),
            'total' => Ticket::count(),
        ];

        $recentTickets = Ticket::with(['user', 'app'])
            ->latest()
            ->limit(10)
            ->get();

        return Inertia::render('Dashboard/Index', [
            'stats' => $stats,
            'recentTickets' => $recentTickets,
        ]);
    }
}
