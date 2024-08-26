<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Sheet\SheetController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [PostController::class, 'portalIndex'])->name('portal.post.index');

    Route::get('/sheets/{sheet}', [SheetController::class, 'portalIndex'])->name('portal.sheets.index');
});


