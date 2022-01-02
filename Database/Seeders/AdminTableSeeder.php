<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\Role;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Model::unguard();
        $adminRole = Role::firstOrCreate(
            [
                'name' => 'admin',
                'title' => 'Administrator',
            ]
        );
        if (!$adminRole->wasRecentlyCreated) {
            Bouncer::allow($adminRole->name)->everything();
        }
        $admin = Admin::where('email', 'admin@admin.admin')->first();
        if (!$admin) {
            $admin = Admin::create(
                [
                    'name' => 'admin',
                    'login' => 'admin',
                    'email' => 'admin@admin.admin',
                    'password' => 'admin',
                    'active' => 1
                ]
            );
            Bouncer::allow($admin)->everything();
            $admin->assign($adminRole->name);
        }
    }
}
