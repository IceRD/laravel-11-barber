<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sheet\SheetController;
use App\Http\Middleware\RoleSysAdmin;

Route::group(['prefix' => 'sheets', 'middleware' => RoleSysAdmin::class], function () {
    Route::get('/', [SheetController::class, 'index'])->name('dashboard.sheets.index');

    Route::get('/!new', [SheetController::class, 'create'])->name('dashboard.sheets.create');
    Route::post('/', [SheetController::class, 'store'])->name('dashboard.sheets.store');

    Route::get('/{sheet}', [SheetController::class, 'edit'])->name('dashboard.sheets.edit');
    Route::patch('/{sheet}', [SheetController::class, 'update'])->name('dashboard.sheets.update');
});
