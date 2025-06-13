<?php

return [

    'default' => env('THEME_DEFAULT', 'default'),

    'paths' => [
        'views' => env('THEME_VIEWS_PATH', resource_path('themes')),
        //Los assets deben estar en public para que sean accesibles desde el navegador
        'assets' => env('THEME_ASSETS_PATH', public_path('themes')),
        'stubs' => env('THEME_STUBS_PATH', resource_path('themes/stubs')),
    ]

];