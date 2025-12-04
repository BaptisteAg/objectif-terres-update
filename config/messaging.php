<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blacklisted Emails (Backup - now managed in database via Nova)
    |--------------------------------------------------------------------------
    */
    'blacklisted_emails' => [
        'bourse.familiale.france75001@gmail.com',
        'olivier.contini75000@gmail.com',
        'financesloan3@gmail.com',
        'goffrtbenoit@gmail.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Spam Patterns (Backup - now managed in database via Nova)
    |--------------------------------------------------------------------------
    */
    'spam_patterns' => [
        'investisseur particulier digne de confiance',
        'bourse familiale non remboursable',
        'fmi à lancer',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configuration for message rate limiting.
    | Staff members (role >= 1) are exempt from rate limiting.
    |
    */
    'rate_limit' => [
        'max_attempts' => 1,
        'decay_minutes' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | reCAPTCHA v3
    |--------------------------------------------------------------------------
    |
    | Google reCAPTCHA v3 configuration for bot detection.
    | Get keys from: https://www.google.com/recaptcha/admin
    |
    */
    'recaptcha' => [
        'enabled' => env('RECAPTCHA_ENABLED', true),
        'site_key' => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
        'min_score' => env('RECAPTCHA_MIN_SCORE', 0.5), // 0.0 = bot, 1.0 = human
    ],
];
