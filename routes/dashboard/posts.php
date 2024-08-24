<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index'])->name('dashboard.posts.index');

    Route::get('/!new', [PostController::class, 'create'])->name('dashboard.posts.create');
    Route::post('/', [PostController::class, 'store'])->name('dashboard.posts.store');

    Route::get('/{user}', [PostController::class, 'edit'])->name('dashboard.posts.edit');
    Route::patch('/{user}', [PostController::class, 'update'])->name('dashboard.posts.update');
});
