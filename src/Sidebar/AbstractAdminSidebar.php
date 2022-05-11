<?php

namespace Modules\Admin\src\Sidebar;

use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender;
use Route;

abstract class AbstractAdminSidebar implements SidebarExtender
{
    abstract public function extendWith(Menu $menu): object;

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return ucfirst(module_prefix());
    }

    /**
     * @param $route
     * @return string
     * @throws \Exception
     */
    public function adminRoute($route): string
    {
        $base = 'admin.';
        $route = $base . $route;
        if (!Route::has($route)) {
            throw new \Exception('Route name: ' . $route . ' cannot exists');
        }
        return $route;
    }

    /**
     * @param $permissions
     * @return int
     */
    public function hasAnyPermissions($permissions)
    {
        return count(
            array_filter($permissions, function ($item) {
                return $item;
            })
        );
    }
}
