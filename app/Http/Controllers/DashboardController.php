<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Models\AiConversation;
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

            // AI Stats
            'ai_solve_rate' => $this->getAiSolveRate(),
            'ai_cost_this_month' => $this->getAiCostThisMonth(),
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

    /**
     * Calculate percentage of closed tickets that were resolved by AI.
     *
     * A ticket is "resolved by AI" if it is resolved/closed and has at least
     * one AI conversation record.
     */
    protected function getAiSolveRate(): float
    {
        $totalClosed = Ticket::whereIn('status', [
            TicketStatus::Resolved->value,
            TicketStatus::Closed->value,
        ])->count();

        if ($totalClosed === 0) {
            return 0;
        }

        $aiResolved = Ticket::whereIn('status', [
            TicketStatus::Resolved->value,
            TicketStatus::Closed->value,
        ])->whereHas('aiConversations')->count();

        return round(($aiResolved / $totalClosed) * 100, 1);
    }

    /**
     * Sum AI costs for the current month.
     */
    protected function getAiCostThisMonth(): float
    {
        $cost = AiConversation::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('cost');

        return round((float) $cost, 4);
    }
}
