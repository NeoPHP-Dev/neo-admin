<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/logger.config.php

return [
    'enabled' => true,

    'channels' => [
        'framework' => [
            'enabled'   => false,
            'name'      => 'framework',
            'extension' => 'log',
        ],
        'security' => [
            'enabled'   => true,
            'name'      => 'security',
            'extension' => 'log'
        ]
    ],

    'rotation' => [
        'enabled'       => false,
        'type'          => 'daily',
        'max_file_size' => 5 * 1024 * 1024,
    ],

    'archive' => [
        'enabled'   => false,
        'extension' => 'zip',
    ],

    'log_format' => "[{%datetime%}][{%level_name%}][{%level_code%}] [{%origin%}] {%message%} {%context%}",
    'min_level'  => 'DEBUG',
];