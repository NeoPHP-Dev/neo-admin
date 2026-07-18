<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/auth.config.php

return [
    'auth' => [
        'enabled'    => true,
        'model'      => Neo\Src\Neo_Admin\Database\Model\Administrator::class,
        'identifier' => 'username',
        'password'   => 'password',
        'guard'      => 'session',
        'role'       => [
            'model'       => Neo\Src\Neo_Admin\Database\Model\AdministratorRole::class,
            'foreign_key' => 'role_id',
            'field'       => 'label',
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
    ],
];