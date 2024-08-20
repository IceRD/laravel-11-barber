<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard.users.index');
});
