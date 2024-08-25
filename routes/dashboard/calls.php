<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Call\CallController;


Route::group(['prefix' => 'calls'], function () {
    Route::get('/', [CallController::class, 'index'])->name('dashboard.calls.index');

    Route::get('/{call}', [CallController::class, 'edit'])->name('dashboard.calls.edit');
    Route::patch('/{call}', [CallController::class, 'update'])->name('dashboard.calls.update');
});
