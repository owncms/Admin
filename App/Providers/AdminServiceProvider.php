<?php

namespace Modules\Admin\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Admin\App\Providers\SidebarServiceProvider;
use Modules\Admin\App\Providers\BouncerServiceProvider;
use Modules\Admin\App\Models\Admin;
use Bouncer;
use Application;
use Modules\Admin\App\Models\Role;
use Modules\Admin\App\Observers\RoleObserver;
use Modules\Admin\App\Observers\AdminObserver;
use Modules\Core\App\Providers\Base\ModuleServiceProvider;

class AdminServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Admin';
    protected $moduleNameLower = 'admin';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $router = $this->app['router'];
//        $router->pushMiddlewareToGroup('web', \Modules\Admin\Http\Middleware\AdminMiddleware::class);
        $router->pushMiddlewareToGroup('web', \Modules\Admin\App\Http\Middleware\ScopeBouncer::class);
        $this->registerMiddlewares();

        parent::boot();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Bouncer', 'Silber\Bouncer\BouncerFacade');
    }

    /**
     * DCms
     * Register middleware list
     *
     * @return void
     */
    public function registerMiddlewares()
    {
        $router = $this->app['router'];
        $middlewares = config('admin.middlewares');
        if (is_array($middlewares)) {
            foreach ($middlewares as $alias => $namespace) {
                $router->aliasMiddleware($alias, $namespace);
            }
        }
    }

    /**
     * @return void
     */
    public function registerObservers(): void
    {
        Role::observe(RoleObserver::class);
        Admin::observe(AdminObserver::class);
    }
}
