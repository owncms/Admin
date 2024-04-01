<?php

namespace Modules\Admin\App\src\Sidebar;

use Modules\Admin\App\Models\Admin;
use Modules\Admin\App\Models\Role;
use Modules\Admin\App\src\Sidebar\AbstractAdminSidebar;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Bouncer;

class SidebarExtender extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): object
    {
        $permissions = [
            'canUsers' => Bouncer::can('index', Admin::class),
            'canRoles' => Bouncer::can('index', Role::class),
        ];

        if ($this->hasAnyPermissions($permissions)) {
            $menu->group($this->getModuleName(), function (Group $group) use ($permissions) {
                $group->item('Admin', function (Item $item) use ($permissions) {
                    $item->icon('fa fa-users');

                    if ($permissions['canUsers']) {
                        $item->item(trans('admin::sidebar.users'), function (Item $item) {
                            $item->route($this->adminRoute('admins.index'));
                            $item->icon('');
                        });
                    }
                    if ($permissions['canRoles']) {
                        $item->item(trans('admin::sidebar.roles'), function (Item $item) {
                            $item->route($this->adminRoute('roles.index'));
                            $item->icon('');
                        });
                    }
                });
            });
        }
        return $menu;
    }
}
