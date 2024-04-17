<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('login.login');
});
Route::get('/forget-password',function(){
    return view('login.forget-password');
});
Route::get('/reset-password', function(){
    return view('login.reset-password');
});
Route::get('/dashboard',function(){
    return view('dashboard.dashboard');
});
Route::get('/users-list',[UserController::class,'index']);
Route::get('/user-add',[UserController::class,'add']);
Route::post('/user-save',[UserController::class,'save']);
