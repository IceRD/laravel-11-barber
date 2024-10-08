<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\RoleSysAdmin;

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard.users.index');

    Route::group(['middleware' => RoleSysAdmin::class], function () {
        Route::get('/!new', [UserController::class, 'create'])->name('dashboard.users.create');
        Route::post('/', [UserController::class, 'store'])->name('dashboard.users.store');
    });

    Route::get('/{user}', [UserController::class, 'edit'])->name('dashboard.users.edit');
    Route::patch('/{user}', [UserController::class, 'update'])->name('dashboard.users.update');
});
