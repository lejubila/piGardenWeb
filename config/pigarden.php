<?php
return [
    'socket_client_ip' => env('PIGARDEN_SOCKET_CLIENT_IP', '127.0.0.1'),
    'socket_client_port' => env('PIGARDEN_SOCKET_CLIENT_PORT', 8084),
    'tz' => env('PIGARDEN_TZ', 'Europe/Rome'),
    'pigarden_version_support' => [
        'ver' => 0,
        'sub' => 2,
    ],
];