<?php

namespace Modules\Admin\App\Models;

use Modules\Core\App\Models\AuthModel;
use Illuminate\Notifications\Notifiable;
use \Silber\Bouncer\Database\HasRolesAndAbilities;

class Admin extends AuthModel
{
    use Notifiable;
    use HasRolesAndAbilities;

    protected $guard = 'admin';

    protected $fillable = [
        'last_name',
        'name',
        'login',
        'email',
        'password',
        'active',
        'last_login_at',
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
        'last_login_at',
    ];

    protected $appends = [
        'role',
        'is_protected'
    ];

    public array $searchableColumns = [
        'name',
        'active',
        'deleted_at'
    ];

    /**
     * @param $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = \Hash::make($password);
        }
    }

    /**
     * @return bool
     */
    public function getIsProtectedAttribute(): bool
    {
        return $this->id == 1;
    }
}
