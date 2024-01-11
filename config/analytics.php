<?php return [
    'matomo' => [
        'enabled' => env('MATOMO_ENABLED', false),
        'domain' => env('MATOMO_DOMAIN', 'terredeliens.matomo.cloud'),
        'site_id' => env('MATOMO_SITE_ID'),
    ],
];