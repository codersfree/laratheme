<?php

return [

    'default' => env('THEME_DEFAULT', 'default'),

    'active' => env('THEME_ACTIVE', 'default'),

    'paths' => [
        'views' => env('THEME_VIEWS_PATH', resource_path('themes')),
        'assets' => env('THEME_ASSETS_PATH', public_path('themes')),
        'stubs' => env('THEME_STUBS_PATH', resource_path('themes/stubs')),
    ]

];