<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Manager;
use App\Http\Middleware\Member;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.submit.login');
});

// Authenticated admin routes
Route::middleware(['auth:sanctum', 'web', 'CheckAuthStatus'])->group(function () {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    // User management routes
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {

        // Routes for admins
        Route::middleware(Admin::class)->group(function () {
            Route::delete('/{id}', 'destroy')->name('destroy');
            Route::put('status', 'status')->name('status');
            Route::post('create', 'create')->name('create');
        });

        // Routes for managers
        Route::middleware(Manager::class)->group(function () {
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
        });

        // Routes for members
        Route::middleware(Member::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('view/{id}', 'view')->name('view');
        });
    });

    // Profile routes
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {

        // Routes for members
        Route::middleware(Member::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('view/{id}', 'view')->name('view');
            Route::post('update', 'updateProfile')->name('update');
            Route::post('update-password', 'updatePassword')->name('update.password');
        });
    });
});


// Route::name('users.')
//     ->prefix('users')
//     ->controller(UsersController::class)->group(function () {
//         Route::get('/', 'index')->name('index');
//         Route::get('blocked', 'index')->name('blocked');
//         Route::get('deleted', 'index')->name('deleted');
//         Route::post('store', 'store')->name('store');
//         Route::get('edit/{id}', "edit")->name('edit');
//         Route::delete('/{id}', 'destroy')->name('destroy');
//         Route::post('update', 'update')->name('update');
//         Route::put('status', 'status')->name('status');
//         Route::get('view/{id}', 'showUser')->name('show');
//     });
