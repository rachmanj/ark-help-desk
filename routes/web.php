<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KBArticleController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');

    // KB Articles (admin only for create/edit)
    Route::get('/kb', [KBArticleController::class, 'index'])->name('kb.index');
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('/kb/create', [KBArticleController::class, 'create'])->name('kb.create');
        Route::post('/kb', [KBArticleController::class, 'store'])->name('kb.store');
        Route::get('/kb/{kbArticle}/edit', [KBArticleController::class, 'edit'])->name('kb.edit');
        Route::patch('/kb/{kbArticle}', [KBArticleController::class, 'update'])->name('kb.update');
    });
});

// Redirect root to dashboard
Route::get('/', fn () => redirect('/dashboard'));
