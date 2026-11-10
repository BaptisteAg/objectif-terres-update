<?php

return [
    'remote' => [
        'database' => [
            'name' => env('DBCOPY_REMOTE_DB_NAME', ''),
            'user' => env('DBCOPY_REMOTE_DB_USER', ''),
            'host' => env('DBCOPY_REMOTE_DB_HOST', 'localhost'),
            'port' => env('DBCOPY_REMOTE_DB_PORT', '3306'),
        ],
        'ssh' => [
            'host' => env('DBCOPY_REMOTE_SSH_HOST', ''),
            'user' => env('DBCOPY_REMOTE_SSH_USER', ''),
            'private_key' => env('DBCOPY_REMOTE_SSH_PRIVATE_KEY', ''),
        ],
    ],
    'local' => [
        'database' => [
            'name' => env('DBCOPY_LOCAL_DB_NAME', ''),
            'user' => env('DBCOPY_LOCAL_DB_USER', 'root'),
            'host' => env('DBCOPY_LOCAL_DB_HOST', 'localhost'),
            'port' => env('DBCOPY_LOCAL_DB_PORT', '3306'),
        ],
    ],
    'dump-opts' => env('DBCOPY_DUMP_OPTS', '--opt'),
];
