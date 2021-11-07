<?php

namespace Modules\Admin\src\Sidebar;

use Maatwebsite\Sidebar\Presentation\SidebarRenderer;
use Modules\Admin\src\Sidebar\AdminSidebar;

class SidebarCreator
{
    protected $sidebar;

    protected $renderer;

    public function __construct(AdminSidebar $sidebar, SidebarRenderer $renderer)
    {
        $this->sidebar = $sidebar;
        $this->renderer = $renderer;
    }

    public function create($view)
    {
        $view->sidebar = $this->renderer->render(
            $this->sidebar
        );
    }
}
