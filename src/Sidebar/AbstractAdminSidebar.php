<?php

namespace Modules\Admin\src\Sidebar;

use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender;
use Route;

abstract class AbstractAdminSidebar implements SidebarExtender
{
    abstract public function extendWith(Menu $menu): object;

    public function getModuleName(): string
    {
        return ucfirst(module_prefix());
    }

    public function adminRoute($route): string
    {
        $base = 'admin.';
        $route = $base . $route;
        if (!Route::has($route)) {
//            dd(get_called_class());
        }
        return $route;
    }
}
