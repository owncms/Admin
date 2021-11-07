<?php

namespace Modules\Admin\Providers;

use Maatwebsite\Sidebar\SidebarServiceProvider as BaseSidebarServiceProvider;

class SidebarServiceProvider extends BaseSidebarServiceProvider
{
    protected $defer = false;

    /**
     * Extended boot from Maatwebsite\Sidebar
     */
    public function boot()
    {
        $this->registerViews();
        \View::creator(
            'admin::partials.sidebar',
            '\Modules\Admin\src\Sidebar\SidebarCreator'
        );
    }

    /**
     * Register extended views from Maatwebsite\Sidebar
     *
     * @return void
     */
    public function registerViews()
    {
        $sourcePath = module_path('Admin', 'Resources/views/sidebar');

        $this->loadViewsFrom($sourcePath, 'sidebar');
    }

}
