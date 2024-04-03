<?php return [
    'matomo' => [
        'enabled' => env('MATOMO_ENABLED', false),
        'url' => env('MATOMO_URL', 'https://cdn.matomo.cloud/terredeliens.matomo.cloud/container_jbj2ARO0.js'),
    ],
    'google' => [
        'enabled' => env('GOOGLE_ENABLED', false),
        'site_id' => env('GOOGLE_SITE_ID'),
    ],
];