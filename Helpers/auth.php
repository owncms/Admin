<?php

if (!function_exists('admin')) {
    function admin(): object
    {
        return Illuminate\Support\Facades\Auth::guard('admin')->user();
    }
}

if (!function_exists('admin_route')) {
    function admin_route($route): string
    {
        return route('admin.' . $route);
    }
}
