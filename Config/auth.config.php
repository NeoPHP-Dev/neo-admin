<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/auth.config.php

return [
    'enabled'    => true,
    'model'      => Neo\Src\Neo_Admin\Database\Model\Administrator::class,
    'identifier' => 'username',
    'password'   => 'password',
    'guard'      => 'session',
    'role'       => [
        'model'       => '',
        'foreign_key' => '',
        'field'       => '',
    ],
    'options' => [
        'login'      => '',
        'logout'     => '',
        'home'       => '',
        'secret'     => '',
        'expiration' => 3600,
        'timeout'    => 1800,
        'algorithm'  => 'HS256',
    ],
];