<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\HomeController;

Route::get('login', [AuthController::class, 'index'])->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth'],function (){
    Route::get('dashboard',[HomeController::class,'index'])->name('dashboard');
    Route::get('logout',[AuthController::class,'destroy'])->name('logout');
});
