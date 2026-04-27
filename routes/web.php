<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware(['auth', 'verified'])->group(function () {

    // Smart redirect based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin & Manager routes
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
    });

    // Regular user routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    });

    // Profile (all roles)
    Route::get('/profile',            [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile',         [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';