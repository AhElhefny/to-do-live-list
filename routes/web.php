<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController;
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



Route::resource('users', UserController::class);

//                  admin Routes                          //
Route::group([], __DIR__ . '/admin.php');


