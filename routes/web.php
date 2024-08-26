<?php

use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';
require __DIR__.'/portal.php';

Route::group(['middleware' => ['auth'], 'prefix' => 'dashboard'], function () {
    Route::get('/', function() { return redirect('/dashboard/users'); });

    require __DIR__ . '/dashboard/users.php';
    require __DIR__ . '/dashboard/posts.php';
    require __DIR__ . '/dashboard/partners.php';
    require __DIR__ . '/dashboard/calls.php';
    require __DIR__ . '/dashboard/sheets.php';
});


