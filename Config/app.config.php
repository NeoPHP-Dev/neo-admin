<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/app.config.php

return [
    'general' => [
        'name'        => "Neo_Admin",
        'description' => "Votre projet NeoPHP",
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
            'en' => 'Anglais',
        ],
    ],

    'auth' => [
        'enabled'    => false,
        'model'      => '',
        'identifier' => '',
        'password'   => '',
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