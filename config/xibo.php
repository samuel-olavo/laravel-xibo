<?php

return [
    'default' => env('XIBO_DEFAULT_CONNECTION', 'default'),
    'connections' => [
        'default' => [
            'url' => env('XIBO_URL'),
            'version' => env('XIBO_VERSION'),
            'token' => env('XIBO_TOKEN'),
            'client_id' => env('XIBO_CLIENT_ID'),
            'client_secret' => env('XIBO_CLIENT_SECRET'),
            'specification_path' => env('XIBO_SPECIFICATION_PATH'),
        ],
    ],
];
