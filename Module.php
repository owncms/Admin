<?php

namespace Modules\Admin;

use Illuminate\Support\Facades\Artisan;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\Role;
use Modules\Core\src\Modules\BaseModule;
use Bouncer;

class Module extends BaseModule
{
    public function __construct()
    {

    }

    public function install()
    {
        Artisan::call('module:migrate Admin');

    }
}
