<?php

return [
    [
        'label' => 'Dashboard',
        'icon' => 'ri-dashboard-horizontal-fill',
        'route' => 'dashboard',
    ],
    [
        'label' => 'Example',
        'icon' => 'polaris-home-filled-icon',
        'route' => 'home',
    ],
    [
        'label' => 'Example 2',
        'icon' => 'heroicon-s-archive-box',
        'submenu' => [
            [
                'label' => 'Submenu 1',
                'route' => 'home',
            ],
            [
                'label' => 'Submenu 2',
                'route' => 'home',
            ],
        ],
    ],
];
