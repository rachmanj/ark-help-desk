<?php

return [
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    'webhook_secret' => env('TELEGRAM_WEBHOOK_SECRET'),
    'admin_id' => env('TELEGRAM_ADMIN_ID'),

    // Bot username (set after token is configured)
    'bot_username' => env('TELEGRAM_BOT_USERNAME', 'ARKAHelpDeskBot'),

    // Webhook settings
    'webhook_url' => env('TELEGRAM_WEBHOOK_URL', env('APP_URL') . '/api/telegram/webhook'),

    // Rate limits
    'rate_limit_webhook' => env('TELEGRAM_RATE_LIMIT_WEBHOOK', '60,1'),
    'rate_limit_ticket_create' => env('TELEGRAM_RATE_LIMIT_TICKET', '5,3600'),
];
