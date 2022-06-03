<?php

if (!function_exists('admin')) {
    function admin(): object
    {
        return Illuminate\Support\Facades\Auth::guard('admin')->user();
    }
}

if (!function_exists('admin_route')) {
    function admin_route($route, $params = []): string
    {
//        if (\Route::has($route)) {
            return route('admin.' . $route, $params);
//        }
//        return false;
    }
}
