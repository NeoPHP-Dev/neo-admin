<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/session.config.php

return [
    'session' => [
        'enabled'   => true,
        'name'      => 'NEO_ADMIN_SESSION',
        'lifetime'  => 3600,
        'path'      => '/',
        'domain'    => null,
        'secure'    => false,
        'http_only' => true,
        'same_site' => 'Lax',

        'storage' => [
            'enabled' => true,
            'handler' => 'files',
        ],
    ],

    'cookie' => [
        'prefix'    => 'neo_admin_',
        'path'      => '/',
        'domain'    => null,
        'secure'    => false,
        'http_only' => true,
        'same_site' => 'Lax',
        'lifetime'  => 86400 * 30,
    ],

    'flash' => [
        'session_key' => '_flash_neo_admin',
        'types'       => ['success', 'error', 'warning', 'info'],
        'auto_expire' => true,
    ],
];