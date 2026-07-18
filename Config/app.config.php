<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/app.config.php

return [
    'general' => [
        'name'          => "NeoAdmin",
        'description'   => "Administration NeoPHP", // @translatable
        'version'       => "1.0.0",
        'icon'          => "code-xml",
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
            'fr' => 'Français', // @translatable
            'en' => 'Anglais', // @translatable
        ],
    ],

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