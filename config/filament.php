<?php

return [
    'path' => env('FILAMENT_PATH', ''),
    'domain' => env('FILAMENT_DOMAIN'),
    'home_url' => '/',
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
        'pages' => [
            'login' => \Filament\Pages\Auth\Login::class,
        ],
    ],
    'pages' => [
        'namespace' => 'App\\Filament\\Pages',
        'path' => app_path('Filament/Pages'),
        'register' => [],
    ],
    'resources' => [
        'namespace' => 'App\\Filament\\Resources',
        'path' => app_path('Filament/Resources'),
        'register' => [],
    ],
    'widgets' => [
        'namespace' => 'App\\Filament\\Widgets',
        'path' => app_path('Filament/Widgets'),
        'register' => [],
    ],
    'middleware' => [
        'auth' => [
            'enabled' => true,
            'redirect' => 'login',
        ],
        'base' => [
            'web',
            'auth',
        ],
    ],
]; 