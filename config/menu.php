<?php

return [
    [
        'label' => 'Dashboard',
        'icon' => 'mage:dashboard-fill',
        'route' => 'dashboard',
    ],
    [
        'label' => 'Example',
        'icon' => 'mdi:home',
        'route' => 'home',
    ],
    [
        'label' => 'Example 2',
        'icon' => 'mingcute:settings-3-fill',
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
