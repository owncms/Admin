<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Core\Http\Controllers\CoreController;
use Application;

class Controller extends CoreController
{
    public function __construct()
    {
        $this->modulePrefix = strtolower(Application::getModulePrefix(get_called_class()));
        $notAdminModule = $this->modulePrefix !== 'admin' ? 'admin.' : '';
        $this->routeWithModulePrefix = $notAdminModule . implode('.', [$this->modulePrefix, $this->baseRoute]);
    }

    public function getBaseRoute()
    {
        return $this->baseRoute ?? '';
    }
}
