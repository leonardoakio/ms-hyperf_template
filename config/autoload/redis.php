<?php declare(strict_types=1);

$redis_host = env('REDIS_HOST', 'localhost');
$redis_hosts = explode(',', $redis_host);
$redis_hosts = array_map('trim', $redis_hosts);

return [
    'default' => [
        'host' => $redis_hosts[0],
        'auth' => env('REDIS_AUTH', null),
        'port' => (int) env('REDIS_PORT', 6379),
        'db' => (int) env('REDIS_DB', 0),
        'cluster' => [
            'enable' => count($redis_hosts) > 1,
            'seeds' => $redis_hosts,
            'persistent' => true,
        ],
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 5,
            'connect_timeout' => 10.0,
            'wait_timeout' => env('REDIS_WAIT_TIMEOUT', 5.0),
            'heartbeat' => -1,
            'max_idle_time' => (float) env('REDIS_MAX_IDLE_TIME', 60),
        ],
    ],
];
