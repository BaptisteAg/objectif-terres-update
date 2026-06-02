<?php

/**
 * Salesforce REST API (Forrest) configuration.
 *
 * Headless server-to-server auth via OAuth 2.0 Client Credentials.
 * The Connected App must have "Enable Client Credentials Flow" turned on
 * and a "Run As" user assigned. SF_LOGIN_URL must be the org's My Domain URL
 * (Client Credentials does not work against login/test.salesforce.com).
 */
return [
    'authentication' => env('SF_AUTHENTICATION', 'ClientCredentials'),

    'credentials' => [
        'consumerKey'    => env('SF_CONSUMER_KEY'),
        'consumerSecret' => env('SF_CONSUMER_SECRET'),
        'loginURL'       => env('SF_LOGIN_URL'),
    ],

    'defaults' => [
        'method'          => 'get',
        'format'          => 'json',
        'compression'     => false,
        'compressionType' => 'gzip',
    ],

    'storage' => [
        'type'          => 'cache',
        'path'          => 'forrest_',
        'expire_in'     => 120,
        'store_forever' => true,
    ],

    'version'     => '',
    'instanceURL' => '',
    'language'    => 'en_US',
];
