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
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);
        if (!$adminRole->wasRecentlyCreated) {
            Bouncer::allow($adminRole->name)->everything();
        }
        $admin = Admin::where('email', 'admin@admin.admin')->first();
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'admin',
                'login' => 'admin',
                'email' => 'admin@admin.admin',
                'password' => 'admin',
                'active' => 1
            ]);
            Bouncer::allow($admin)->everything();
            $admin->assign($adminRole->name);
        }
    }
}
