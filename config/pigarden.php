<?php
return [
    'socket_client_ip' => env('PIGARDEN_SOCKET_CLIENT_IP', '127.0.0.1'),
    'socket_client_port' => env('PIGARDEN_SOCKET_CLIENT_PORT', 8084),
    'socket_client_user' => env('PIGARDEN_SOCKET_CLIENT_USER', ''),
    'socket_client_pwd' => env('PIGARDEN_SOCKET_CLIENT_PWD', ''),
    'tz' => env('PIGARDEN_TZ', 'Europe/Rome'),
    'pigarden_version_support' => [
        'ver' => 0,
        'sub' => 6,
    ],

    'cron_in' => [
        'start' => [ 0, 5, 10, 15, 30, 60, 120, 180, 240, 300, 600 ],
        'length' => [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20, 30, 60, 120, 180, 240, 300 ]
    ],

    'timeout_json_dashboard_status' => env('PIGARDEN_TIMEOUT_DASHBOARD_STATUS', 20000),

    'max_record_log' => env('PIGARDEN_MAX_RECORD_LOG', 0),

    'version' => [
        'ver' => 0,
        'sub' => 6,
        'rel' => 2
    ],
];
