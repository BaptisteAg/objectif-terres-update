<?php return [
    'matomo' => [
        'enabled' => env('MATOMO_ENABLED', false),
        'domain' => env('MATOMO_DOMAIN', 'terredeliens.matomo.cloud'),
        'site_id' => env('MATOMO_SITE_ID'),
    ],
    'google' => [
        'enabled' => env('GOOGLE_ENABLED', false),
        'site_id' => env('GOOGLE_SITE_ID'),
    ],
];