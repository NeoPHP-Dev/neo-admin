<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/cache.config.php

return [
    'enabled' => true,
    'driver'  => 'files',
    'ttl'     => 3600,

    'drivers' => [
        'files' => [
            'path' => '/var/cache/app/',
        ],
        'redis' => [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'password' => null,
            'database' => 0,
            'prefix'   => '',
        ],
        'array' => [],
    ],
];