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

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Admin';

    /**
     * @var string $moduleNameLower
     */
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

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

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
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
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

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
