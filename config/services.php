<?php

return [

    'postmark' => ['key' => env('POSTMARK_API_KEY')],
    'resend' => ['key' => env('RESEND_API_KEY')],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // AI configuration — supports DeepSeek and OpenRouter
    'ai' => [
        'provider' => env('AI_PROVIDER', 'deepseek'),
        'key' => env('AI_API_KEY'),
        'model' => env('AI_MODEL', 'deepseek-chat'),
        'max_tokens' => env('AI_MAX_TOKENS', 1024),
        'temperature' => env('AI_TEMPERATURE', 0.7),
    ],

];
