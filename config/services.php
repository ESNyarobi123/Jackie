<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

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

    'clickpesa' => [
        'base_url' => env('CLICKPESA_BASE_URL', 'https://api.clickpesa.com/third-parties'),
        'client_id' => env('CLICKPESA_CLIENT_ID'),
        'api_key' => env('CLICKPESA_API_KEY'),
        'checksum_key' => env('CLICKPESA_CHECKSUM_KEY'),
        'checksum_enabled' => (bool) env('CLICKPESA_CHECKSUM_ENABLED', false),
        'token_cache_key' => env('CLICKPESA_TOKEN_CACHE_KEY', 'clickpesa.token'),
        'timeout' => (int) env('CLICKPESA_TIMEOUT', 20),
        'connect_timeout' => (int) env('CLICKPESA_CONNECT_TIMEOUT', 10),
        'retry_times' => (int) env('CLICKPESA_RETRY_TIMES', 2),
        'retry_sleep_ms' => (int) env('CLICKPESA_RETRY_SLEEP_MS', 250),
    ],

    'payment_webhooks' => [
        'secret' => env('PAYMENT_WEBHOOK_SECRET'),
        'allow_manual' => (bool) env('PAYMENT_WEBHOOK_ALLOW_MANUAL', false),
    ],

    'jitsi' => [
        'scheme' => env('JITSI_SCHEME', 'https'),
        'domain' => env('JITSI_DOMAIN', 'meet.jit.si'),
        'external_api_url' => env('JITSI_EXTERNAL_API_URL'),
        'room_prefix' => env('JITSI_ROOM_PREFIX', 'jackie-lms'),
        'default_language' => env('JITSI_DEFAULT_LANGUAGE', 'en'),
        'join_window_before_minutes' => (int) env('JITSI_JOIN_WINDOW_BEFORE_MINUTES', 15),
        'join_window_after_minutes' => (int) env('JITSI_JOIN_WINDOW_AFTER_MINUTES', 30),
    ],

];
