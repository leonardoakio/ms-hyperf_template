<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'default' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'host' => env('DB_HOST', 'hyperf-template_mysql'),
        'database' => env('DB_DATABASE', 'hyperf-template'),
        'port' => env('DB_PORT', 3308),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => env('DB_CHARSET', 'utf8'),
        'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('DB_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 5,
            'connect_timeout' => 15,
            'wait_timeout' => env('DB_WAIT_TIMEOUT', 30.0),
            'heartbeat' => 10,
            'max_idle_time' => (float) env('DB_MAX_IDLE_TIME', 30),
        ],
        'commands' => [
            'gen:model' => [
                'path' => 'app/Model',
                'force_casts' => true,
                'inheritance' => 'Model',
            ],
        ],
    ],
];
