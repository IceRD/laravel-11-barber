<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [PostController::class, 'index'])->name('portal.post.index');
});


