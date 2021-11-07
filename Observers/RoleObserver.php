<?php

namespace Modules\Admin\Observers;

use Modules\Admin\Entities\Role;
use Bouncer;

class RoleObserver
{

    /**
     * Handle the Role "saving" event.
     *
     * @param Role $role
     * @return void
     */
    public function saving(Role $role)
    {
        if ($role->id != 1 && request()->has('abilities')) {
            $abilities = request()->get('abilities');
            foreach ($abilities as $model => $crud) {
                foreach ($crud as $method => $status) {
                    if ($status) {
                        Bouncer::allow($role->name)->to($method, $model);
                    } else {
                        Bouncer::disallow($role->name)->to($method, $model);
                    }
                }
            }
        }
    }

    /**
     * Handle the Role "saved" event.
     *
     * @param Role $role
     * @return void
     */
    public function saved(Role $role)
    {
        $data = request()->all();

    }

    /**
     * Handle the User "deleting" event.
     *
     * @param Role $role
     * @return void
     */
    public function deleting(Role $role)
    {
        if ($role->hasAny() == 0) {
            $role->default = 0;
            $role->active = 0;
        }
    }
}
