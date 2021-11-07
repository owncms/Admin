<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Traits\OnlineModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Silber\Bouncer\Database\Concerns\IsRole;
use Silber\Bouncer\Database\Models;

class Role extends Model
{
    use OnlineModel, IsRole;

    protected $fillable = [
        'name',
        'title',
        'level',
        'active'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'level' => 'int',
    ];

    /**
     * Constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = Models::table('roles');

        parent::__construct($attributes);
    }

    public static function getRoles()
    {
        return self::all();
    }

    public static function prepareRolesSelect(): array
    {
        $roles = self::getRoles();
        $preparedRoles = [];
        foreach ($roles as $role) {
            $preparedRoles[$role->id] = $role->name;
        }
        return $preparedRoles;
    }

    public function showableAttributes(): array
    {
        return [
            'name',
            'title'
        ];
    }

    public function hasAny()
    {
        return \DB::table('assigned_roles')->where('role_id', $this->id)->count();
    }

}
