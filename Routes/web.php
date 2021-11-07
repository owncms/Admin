<?php

use Modules\Admin\Http\Controllers\Auth\LoginController;
use Modules\Admin\Http\Controllers\Auth\ResetPasswordController;
use Modules\Admin\Http\Controllers\Backend\DashboardController;
use \Backend\AdminController;
use \Backend\RoleController;

// Authentication
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Password reset
Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
   Route::get('reset', [ResetPasswordController::class, 'showRequestPasswordResetForm'])->name('request');
   Route::post('email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('email');
   Route::get('reset/{token}', [ResetPasswordController::class, 'showResetPassword'])->name('reset');
   Route::post('reset', [ResetPasswordController::class, 'resetPassword'])->name('update');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('admins', AdminController::class);
    Route::resource('roles', RoleController::class);
});

