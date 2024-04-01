<?php

return [
    'name' => 'Admin',
    'middlewares' => [
        // 'alias' => 'namespace'
        'sidebar.resolve' => '\\Maatwebsite\\Sidebar\\Middleware\\ResolveSidebars',
        'scope.bouncer' => 'Modules\\Admin\\App\\Http\\Middleware\\ScopeBouncer'
    ],
];
