<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partner\PartnerController;

Route::group(['prefix' => 'partners'], function () {
    Route::get('/', [PartnerController::class, 'index'])->name('dashboard.partners.index');
    Route::get('/{partner}', [PartnerController::class, 'edit'])->name('dashboard.partners.edit');
    Route::post('/{partner}', [PartnerController::class, 'update'])->name('dashboard.partners.update');
});
