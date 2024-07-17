<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->prefix('auth')->group(function () {

    Route::name('login.')->prefix('login')->controller(LoginController::class)->middleware('guest')->group(function () {
        Route::get('/', 'showFormLogin')->name('index');
        Route::post('/', 'doLogin')->name('post');
    });

});

