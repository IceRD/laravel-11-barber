<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard.users.index');
    Route::get('/{user}', [UserController::class, 'edit'])->name('dashboard.users.edit');
    Route::post('/{user}', [UserController::class, 'update'])->name('dashboard.users.update');
});
