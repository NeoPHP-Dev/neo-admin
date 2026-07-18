<?php
declare(strict_types=1);

// ./src/Neo_Admin/Config/routes.config.php

return [
    'general' => [
        'label' => 'Général',
        'items' => [
            [
                'route' => 'panel.dashboard.index',
                'icon' => 'layout-dashboard',
                'label' => 'Tableau de bord',
                'controller' => Neo\Src\Neo_Admin\App\Controllers\Panel\DashboardController::class,
            ]
        ]
    ],
    'settings' => [
        'label' => 'Paramètres',
        'items' => [
            [
                'route' => 'panel.preference.index',
                'icon' => 'settings',
                'label' => 'Préférences',
                'controller' => \Neo\Src\Neo_Admin\App\Controllers\Panel\PreferenceController::class,
            ]
        ]
    ],
];