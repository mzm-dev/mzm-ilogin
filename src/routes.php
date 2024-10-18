<?php
use Illuminate\Support\Facades\Route;
use Mzm\Ilogin\Http\Controllers\SsoController;

Route::name('sso.')->prefix('sso')->group(function () {
    Route::get('/verify', SsoController::class)->name('verify');
    Route::get('/callback', SsoController::class)->name('callback');
});
