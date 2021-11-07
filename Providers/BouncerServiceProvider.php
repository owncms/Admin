<?php

namespace Modules\Admin\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Admin\Entities\Role;
use Silber\Bouncer\BouncerServiceProvider as BaseBouncerServiceProvider;
use Silber\Bouncer\Database\Models;
use Bouncer;

class BouncerServiceProvider extends BaseBouncerServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Bouncer::useRoleModel(Role::class);
        Relation::morphMap([Role::class]);
    }

    /**
     * Get the user model from the application's auth config.
     *
     * @return string
     */
    protected function getUserModel(): mixed
    {
        $config = $this->app->make('config');

        if (is_null($provider = $config->get("auth.guards.admin.provider"))) {
            return null;
        }

        return $config->get("auth.providers.{$provider}.model");
    }

    /**
     * Set the classname of the user model to be used by Bouncer.
     *
     * @return void
     */
    protected function setUserModel()
    {
        Models::setUsersModel($this->getUserModel());
    }
}
