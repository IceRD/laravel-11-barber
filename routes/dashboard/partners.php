<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partner\PartnerController;

Route::group(['prefix' => 'partners'], function () {
    Route::get('/', [PartnerController::class, 'index'])->name('dashboard.partners.index');

    Route::group(['middleware' => 'isSysAdmin'], function () {
        Route::get('/!new', [PartnerController::class, 'create'])->name('dashboard.partners.create');
        Route::post('/', [PartnerController::class, 'store'])->name('dashboard.partners.store');
    });

    Route::get('/{partner}', [PartnerController::class, 'edit'])->name('dashboard.partners.edit');
    Route::post('/{partner}', [PartnerController::class, 'update'])->name('dashboard.partners.update');
});
