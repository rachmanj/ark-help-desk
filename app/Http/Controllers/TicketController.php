<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Events\TicketResolved;
use App\Models\AppInfo;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'app', 'assignedTo'])
            ->when($request->search, fn ($q, $s) =>
                $q->where('subject', 'like', "%{$s}%")
            )
            ->when($request->status, fn ($q, $s) =>
                $q->where('status', $s)
            )
            ->when($request->priority, fn ($q, $p) =>
                $q->where('priority', $p)
            )
            ->when($request->app_id, fn ($q, $a) =>
                $q->where('app_id', $a)
            )
            ->latest();

        $tickets = $query->paginate($request->per_page ?? 15)->withQueryString();

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,
            'filters' => $request->only(['search', 'status', 'priority', 'app_id']),
            'statuses' => collect(TicketStatus::cases())->map(fn ($s) => [
                'value' => $s->value,
                'label' => $s->label(),
                'color' => $s->color(),
            ]),
            'priorities' => collect(TicketPriority::cases())->map(fn ($p) => [
                'value' => $p->value,
                'label' => $p->label(),
                'color' => $p->color(),
            ]),
            'apps' => AppInfo::where('is_active', true)->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_id' => 'required|exists:apps,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:' . implode(',', TicketPriority::values()),
        ]);

        $ticket = Ticket::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => TicketStatus::Open->value,
            'source' => 'web',
        ]);

        // Add first message
        if ($request->description) {
            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'sender_type' => 'user',
                'sender_id' => Auth::id(),
                'message' => $request->description,
            ]);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'app', 'assignedTo', 'messages' => function ($q) {
            $q->orderBy('created_at');
        }, 'messages.kbArticle']);

        return Inertia::render('Tickets/Show', [
            'ticket' => $ticket,
            'statuses' => collect(TicketStatus::cases())->map(fn ($s) => [
                'value' => $s->value,
                'label' => $s->label(),
            ]),
        ]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'sometimes|required|in:' . implode(',', TicketStatus::values()),
            'priority' => 'sometimes|required|in:' . implode(',', TicketPriority::values()),
            'assigned_to' => 'sometimes|nullable|exists:users,id',
            'message' => 'sometimes|nullable|string',
        ]);

        if (isset($validated['status'])) {
            $oldStatus = $ticket->status;
            if (! $ticket->transitionTo($validated['status'])) {
                return back()->with('error', 'Transisi status tidak valid.');
            }

            // Fire event when ticket is resolved
            if ($validated['status'] === TicketStatus::Resolved->value && $oldStatus !== TicketStatus::Resolved->value) {
                event(new TicketResolved($ticket));
            }
        }

        if (isset($validated['priority'])) {
            $ticket->update(['priority' => $validated['priority']]);
        }

        if (isset($validated['assigned_to'])) {
            $ticket->update(['assigned_to' => $validated['assigned_to']]);
        }

        // Add admin reply
        if (! empty($validated['message'])) {
            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'sender_type' => 'admin',
                'sender_id' => Auth::id(),
                'message' => $validated['message'],
            ]);
        }

        return back()->with('success', 'Tiket berhasil diperbarui.');
    }
}
