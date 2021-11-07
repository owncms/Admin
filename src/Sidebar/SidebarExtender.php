<?php

namespace Modules\Admin\src\Sidebar;

use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\Role;
use Modules\Admin\src\Sidebar\AbstractAdminSidebar;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Bouncer;

class SidebarExtender extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): object
    {
        $canUsers = Bouncer::can('index', Admin::class);
        $canRoles = Bouncer::can('index', Role::class);

        if ($canUsers || $canRoles) {
            $menu->group($this->getModuleName(), function (Group $group) use ($canUsers, $canRoles) {
                $group->item('Admin', function (Item $item) use ($canUsers, $canRoles) {
                    $item->icon('fa fa-cog');

                    if ($canUsers) {
                        $item->item('Users', function (Item $item) {
                            $item->route($this->adminRoute('admins.index'));
                            $item->icon('');
                        });
                    }
                    if ($canRoles) {
                        $item->item('Roles', function (Item $item) {
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
