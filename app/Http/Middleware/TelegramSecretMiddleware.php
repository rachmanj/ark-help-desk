<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TelegramSecretMiddleware
{
    /**
     * Validates the X-Telegram-Bot-Api-Secret-Token header
     * against the configured TELEGRAM_WEBHOOK_SECRET.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('telegram.webhook_secret');

        // Allow in local/dev without secret for testing
        if (app()->environment('local') && empty($secret)) {
            return $next($request);
        }

        $headerSecret = $request->header('X-Telegram-Bot-Api-Secret-Token');

        if (empty($secret) || $headerSecret !== $secret) {
            return response()->json([
                'ok' => false,
                'error' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
