<?php

namespace App\Http\Controllers;

use App\Models\AppInfo;
use App\Models\KBArticle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KBArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = KBArticle::with('app')
            ->when($request->search, fn ($q, $s) =>
                $q->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$s])
                    ->orderByRaw('MATCH(title, content) AGAINST(?) DESC', [$s])
            )
            ->when($request->app_id, fn ($q, $a) =>
                $q->where('app_id', $a)
            )
            ->when(! $request->search, fn ($q) => $q->latest());

        $articles = $query->paginate($request->per_page ?? 15)->withQueryString();

        return Inertia::render('KB/Index', [
            'articles' => $articles,
            'filters' => $request->only(['search', 'app_id']),
            'apps' => AppInfo::where('is_active', true)->get(['id', 'name']),
        ]);
    }

    public function create()
    {
        return Inertia::render('KB/Create', [
            'apps' => AppInfo::where('is_active', true)->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_id' => 'nullable|exists:apps,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'is_published' => 'boolean',
        ]);

        KBArticle::create([
            ...$validated,
            'is_published' => $validated['is_published'] ?? false,
        ]);

        return redirect()->route('kb.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(KBArticle $kbArticle)
    {
        return Inertia::render('KB/Edit', [
            'article' => $kbArticle->load('app'),
            'apps' => AppInfo::where('is_active', true)->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, KBArticle $kbArticle)
    {
        $validated = $request->validate([
            'app_id' => 'nullable|exists:apps,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'is_published' => 'boolean',
        ]);

        $kbArticle->update($validated);

        return redirect()->route('kb.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }
}
