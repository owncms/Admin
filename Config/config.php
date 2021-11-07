<?php

return [
    'name' => 'Admin',
    'middlewares' => [
        // 'alias' => 'namespace'
        'admin' => 'Modules\Admin\Http\Middleware\AdminMiddleware',
        'sidebar.resolve' => '\\Maatwebsite\\Sidebar\\Middleware\\ResolveSidebars',
        'scope.bouncer' => 'Modules\\Admin\\Http\\Middleware\\ScopeBouncer'
    ],
];
