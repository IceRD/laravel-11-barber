<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partner\PartnerController;
use App\Http\Middleware\RoleSysAdmin;

Route::group(['prefix' => 'partners'], function () {
    Route::get('/', [PartnerController::class, 'index'])->name('dashboard.partners.index');

    Route::group(['middleware' => RoleSysAdmin::class], function () {
        Route::get('/!new', [PartnerController::class, 'create'])->name('dashboard.partners.create');
        Route::post('/', [PartnerController::class, 'store'])->name('dashboard.partners.store');
    });

    Route::get('/{partner}', [PartnerController::class, 'edit'])->name('dashboard.partners.edit');
    Route::patch('/{partner}', [PartnerController::class, 'update'])->name('dashboard.partners.update');
});
