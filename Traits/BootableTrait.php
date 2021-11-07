<?php

namespace Modules\Admin\Traits;

use Carbon\Carbon;

trait BootableTrait
{
    public static function boot()
    {
        parent::boot();

        dd(getGuardName());
//        $auth_id = \auth::guard(getGuardName())->id();
////        dd($auth_id);
//        static::updated(function ($table) use ($auth_id) {
//            $table->updated_by = $auth_id;
//            $table->updated_at = Carbon::now();
//        });
//
//        static::updating(function ($table) use ($auth_id) {
//            $table->updated_by = $auth_id;
//            $table->updated_at = Carbon::now();
//        });
//
//        static::deleting(function ($table) use ($auth_id) {
//            $table->deleted_by = $auth_id;
//            $table->deleted_at = Carbon::now();
//            $table->active = 0;
//        });
//
//        static::saving(function ($table) use ($auth_id) {
//            $table->created_by = $auth_id;
//            $table->updated_by = $auth_id;
//            $table->active = 1;
//        });
//
//
//        static::creating(function ($table) use ($auth_id) {
//            $table->created_by = $auth_id;
//            $table->updated_by = $auth_id;
//            $table->active = 1;
//        });
    }
}
