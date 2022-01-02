<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Admin\Providers\SidebarServiceProvider;
use Modules\Admin\Providers\BouncerServiceProvider;
use Modules\Admin\Entities\Admin;
use Bouncer;
use Application;
use Modules\Admin\Entities\Role;
use Modules\Admin\Observers\RoleObserver;
use Modules\Admin\Observers\AdminObserver;
use Modules\Core\Providers\Base\ModuleServiceProvider;

class AdminServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Admin';
    protected $moduleNameLower = 'admin';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app['router'];
//        $router->pushMiddlewareToGroup('web', \Modules\Admin\Http\Middleware\AdminMiddleware::class);
        $router->pushMiddlewareToGroup('web', \Modules\Admin\Http\Middleware\ScopeBouncer::class);
        $this->registerMiddlewares();

        parent::boot();

        $this->registerHelpers();
        $this->registerObservers();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(SidebarServiceProvider::class);
        $this->app->register(BouncerServiceProvider::class);
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

    public function registerHelpers()
    {
        $files_path = module_path('admin', 'Helpers/*.php');

        foreach (glob($files_path) as $file) {
            require_once $file;
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }

    public function registerObservers()
    {
        Role::observe(RoleObserver::class);
        Admin::observe(AdminObserver::class);
    }
}
