<?php

namespace Modules\Admin\Entities;

use Modules\Core\Entities\AuthModel;
use Illuminate\Notifications\Notifiable;
use \Silber\Bouncer\Database\HasRolesAndAbilities;

class Admin extends AuthModel
{
    use Notifiable, HasRolesAndAbilities;

    protected $guard = 'admin';

    protected $fillable = [
        'last_name',
        'name',
        'login',
        'email',
        'password',
        'active',
        'last_login',
    ];

    protected array $attributesUnset = [
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'last_login',
    ];

    protected $appends = [
        'role',
    ];

    public array $searchableColumns = [
        'name',
        'active',
        'deleted_at'
    ];

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = \Hash::make($password);
        }
    }
}
