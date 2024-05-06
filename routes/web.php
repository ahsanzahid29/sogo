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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/users-list',[UserController::class,'index'])->middleware(['auth'])->name('users-list');
Route::get('/user-add',[UserController::class,'add'])->middleware(['auth'])->name('user-add');
Route::post('/user-save',[UserController::class,'save'])->middleware(['auth'])->name('user-save');
Route::get('/user-edit/{id}', [UserController::class, 'edit'])->middleware(['auth'])->name('edituser');
Route::post('/user-update',[UserController::class,'update'])->middleware(['auth'])->name('update-user');
Route::get('/user-password/{id}', [UserController::class, 'changePassword'])->middleware(['auth'])->name('change-password');



Route::get('/inverters-list',[InverterController::class,'index'])->middleware(['auth']);
Route::get('/inverter-add', [InverterController::class,'add'])->middleware(['auth']);
Route::post('/inverter-save',[InverterController::class,'save'])->middleware(['auth'])->name('inverter-add');
Route::get('/inverter-edit/{id}', [InverterController::class, 'edit'])->middleware(['auth'])->name('edit-inverter');
Route::post('/inverter-update',[InverterController::class,'update'])->middleware(['auth'])->name('update-inverter');



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

require __DIR__.'/auth.php';
