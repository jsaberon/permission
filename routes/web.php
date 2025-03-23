<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->middleware('guest')
        ->name('login');

    Route::post('login', [LoginController::class, 'store'])
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::delete('logout', [LoginController::class, 'destroy'])
        ->name('logout');

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('permissions', PermissionController::class)->except(['show', 'destroy']);
});
