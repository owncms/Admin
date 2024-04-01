<?php

namespace Modules\Admin\App;

use Illuminate\Support\Facades\Artisan;
use Modules\Admin\App\Models\Admin;
use Modules\Admin\App\Models\Role;
use Modules\Core\src\Modules\BaseModule;
use Bouncer;

class Module extends BaseModule
{
    public function __construct($module, $overrideMigration = false)
    {
        parent::__construct($module, $overrideMigration);
    }

    /**
     * @return void
     */
    public function install()
    {
        Artisan::call('module:migrate Admin');
        $adminRole = Role::firstOrCreate(
            [
                'name' => 'admin',
                'title' => 'Administrator',
            ]
        );
        if ($adminRole->wasRecentlyCreated) {
            Bouncer::allow($adminRole->name)->everything();
        }
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@admin.admin'],
            [
                'name' => 'admin',
                'login' => 'admin',
                'password' => 'admin',
                'active' => 1
            ]
        );
        if ($admin->wasRecentlyCreated) {
            Bouncer::allow($admin)->everything();
            $admin->assign($adminRole->name);
        }
    }
}
