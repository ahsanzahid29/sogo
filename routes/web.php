<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InverterController;
use App\Http\Controllers\InverterInventoryController;
use App\Http\Controllers\SparePartsController;
use App\Http\Controllers\SparePartsInventoryController;
use App\Http\Controllers\SparePartsInvoiceController;
use App\Http\Controllers\DeliveryNoteController;
use App\Http\Controllers\RepairTicketController;

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
Route::get('/inverters-list',[InverterController::class,'index']);
Route::get('/inverter-add', [InverterController::class,'add']);
Route::post('/inverter-save',[InverterController::class,'save']);
Route::get('/inverters-inventory-list',[InverterInventoryController::class,'index']);
Route::get('/spareparts-list',[SparePartsController::class,'index']);
Route::get('/sparepart-add', [SparePartsController::class,'add']);
Route::post('/sparepart-save',[SparePartsController::class,'save']);
Route::get('/sparepart-inventory-list',[SparePartsInventoryController::class,'index']);
Route::get('/edit-profile',[UserController::class,'editProfile']);
Route::post('/update-profile',[UserController::class,'updateProfile']);
Route::get('/invoice-list',[SparePartsInvoiceController::class,'index']);
Route::get('/invoice-add',[SparePartsInvoiceController::class,'add']);
Route::post('/invoice-save',[SparePartsInvoiceController::class,'save']);
Route::get('/deliverynote-list',[DeliveryNoteController::class,'index']);
Route::get('/deliverynote-add',[DeliveryNoteController::class,'add']);
Route::post('/deliverynote-save',[DeliveryNoteController::class,'save']);
Route::get('/repairticket-list',[RepairTicketController::class,'index']);
Route::get('/all-repairtickets',[RepairTicketController::class,'allTickets']);





