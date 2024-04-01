<?php

namespace Modules\Admin\App\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Core\App\Providers\Base\RouteServiceProvider as BaseRouteServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    protected string $moduleName = 'Admin';
    protected string $moduleNameLower = 'admin';
}
