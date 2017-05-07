<?php
return [
    'socket_client_ip' => env('PIGARDEN_SOCKET_CLIENT_IP', '127.0.0.1'),
    'socket_client_port' => env('PIGARDEN_SOCKET_CLIENT_PORT', 8084),
    'tz' => env('PIGARDEN_TZ', 'Europe/Rome'),
    'pigarden_version_support' => [
        'ver' => 0,
        'sub' => 3,
    ],

    'cron_in' => [
        'start' => [ 0, 5, 15, 30, 60, 120, 180, 240, 300, 600 ],
        'length' => [ 30, 60, 120, 180, 240, 300 ]
    ],
];