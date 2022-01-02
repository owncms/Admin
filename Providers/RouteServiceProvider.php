<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Core\Providers\Base\RouteServiceProvider as BaseRouteServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected string $moduleNamespace = 'Modules\Admin\Http\Controllers';
    protected string $moduleName = 'Admin';
    protected string $moduleNameLower = 'admin';
}
