<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Documentation Authentication
    |--------------------------------------------------------------------------
    |
    | Configure HTTP Basic Authentication for API documentation access.
    |
    */

    // Enable/disable authentication (set to false if nginx already handles auth)
    'auth_enabled' => env('API_DOC_AUTH_ENABLED', true),

    // HTTP Basic Auth credentials
    'username' => env('API_DOC_USERNAME', 'api_admin'),
    'password' => env('API_DOC_PASSWORD'),
];
