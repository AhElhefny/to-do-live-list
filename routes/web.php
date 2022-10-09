<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('login', [AuthController::class, 'index'])->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth'],function (){
    Route::get('dashboard',[HomeController::class,'index'])->name('dashboard');
    Route::get('logout',[AuthController::class,'destroy'])->name('logout');
    Route::get('logout',[AuthController::class,'destroy'])->name('logout');
    Route::resource('roles',RolesController::class);
    Route::resource('users', UserController::class);

});


