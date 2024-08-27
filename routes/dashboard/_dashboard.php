<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'], 'prefix' => 'dashboard'], function () {
    Route::get('/', function() { return redirect('/dashboard/users'); });

    require __DIR__ . '/users.php';
    require __DIR__ . '/posts.php';
    require __DIR__ . '/partners.php';
    require __DIR__ . '/calls.php';
    require __DIR__ . '/sheets.php';
});
