<?php

use App\Http\Controllers\admin\AuthController;

Route::name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'index']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
