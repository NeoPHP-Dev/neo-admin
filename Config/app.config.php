<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/app.config.php

return [
    'general' => [
        'name'          => "NeoAdmin",
        'description'   => "Administration NeoPHP",
        'version'       => "1.0.0"
    ],

    'environment' => "dev",

    'access' => "localhost:8000",

    'date' => [
        'timezone' => 'Europe/Paris',
    ],

    'translation' => [
        'enabled'           => true,
        'default_locale'    => 'fr',
        'available_locales' => [
            'fr' => 'Français',
        ],
    ],

    'auth' => [
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
    ],
];