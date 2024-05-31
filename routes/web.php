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
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SparePartCategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SparePartRequestController;

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
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "Cache Cleared!";

});

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth'])->name('dashboard');


Route::get('/users-list',[UserController::class,'index'])->middleware(['auth'])->name('users-list');
Route::get('/user-add',[UserController::class,'add'])->middleware(['auth'])->name('user-add');
Route::post('/user-save',[UserController::class,'save'])->middleware(['auth'])->name('user-save');
Route::get('/user-edit/{id}', [UserController::class, 'edit'])->middleware(['auth'])->name('edituser');
Route::post('/user-update',[UserController::class,'update'])->middleware(['auth'])->name('update-user');
Route::get('/user-password/{id}', [UserController::class, 'changePassword'])->middleware(['auth'])->name('change-password');
Route::get('/add-password/{uuid}', [GeneralController::class, 'addPassword'])->name('addPassword');
Route::post('/save-password',[GeneralController::class,'savePassword'])->name('password.add');

Route::get('/inverters-list',[InverterController::class,'index'])->middleware(['auth'])->name('list-inverter');
Route::get('/inverter-add', [InverterController::class,'add'])->middleware(['auth'])->name('add-inverter');
Route::post('/inverter-save',[InverterController::class,'save'])->middleware(['auth'])->name('inverter-add');
Route::get('/inverter-edit/{id}', [InverterController::class, 'edit'])->middleware(['auth'])->name('edit-inverter');
Route::post('/inverter-update',[InverterController::class,'update'])->middleware(['auth'])->name('update-inverter');

Route::get('/product-category-list',[ProductCategoryController::class,'index'])->middleware(['auth'])->name('list-inverter-category');
Route::post('/product-category-save',[ProductCategoryController::class,'save'])->middleware(['auth'])->name('product-category-add');
Route::get('/product-category-edit/{id}', [ProductCategoryController::class, 'edit'])->middleware(['auth'])->name('edit-product-category');
Route::post('/product-category-update',[ProductCategoryController::class,'update'])->middleware(['auth'])->name('product-category-update');
Route::get('/product-category-delete/{id}', [ProductCategoryController::class, 'delete'])->middleware(['auth'])->name('delete-product-category');

Route::get('/inverters-inventory-list',[InverterInventoryController::class,'index'])->middleware(['auth'])->name('list-inverter-inventory');
Route::get('/inverters-inventory-add', [InverterInventoryController::class,'add'])->middleware(['auth'])->name('add-inverter-inventory');
Route::post('/inventory-save',[InverterInventoryController::class,'save'])->middleware(['auth'])->name('save-inverter-inventory');

Route::get('/spareparts-category-list',[SparePartCategoryController::class,'index'])->middleware(['auth'])->name('list-category-spartpart');
Route::post('/sparepart-category-save',[SparePartCategoryController::class,'save'])->middleware(['auth'])->name('sparepart-category-add');
Route::get('/sparepart-category-edit/{id}', [SparePartCategoryController::class, 'edit'])->middleware(['auth'])->name('edit-sparepart-category');
Route::post('/sparepart-category-update',[SparePartCategoryController::class,'update'])->middleware(['auth'])->name('sparepart-category-update');
Route::get('/sparepart-category-delete/{id}', [SparePartCategoryController::class, 'delete'])->middleware(['auth'])->name('delete-sparepart-category');

Route::get('/spareparts-list',[SparePartsController::class,'index'])->middleware(['auth'])->name('list-spartpart');
Route::get('/sparepart-add', [SparePartsController::class,'add'])->middleware(['auth'])->name('add-spartpart');
Route::post('/sparepart-save',[SparePartsController::class,'save'])->middleware(['auth'])->name('save-spartpart');
Route::get('/sparepart-edit/{id}', [SparePartsController::class, 'edit'])->middleware(['auth'])->name('edit-sparepart');
Route::get('/sparepartmodel-delete/{id}', [SparePartsController::class, 'deleteModel'])->middleware(['auth'])->name('delete-sparepart-model');
Route::post('/sparepart-update',[SparePartsController::class,'update'])->middleware(['auth'])->name('update-spartpart');

Route::get('/sparepart-inventory-list',[SparePartsInventoryController::class,'index'])->middleware(['auth'])->name('list-sparepart-inventory');
Route::get('/sparepart-inventory-add', [SparePartsInventoryController::class,'add'])->middleware(['auth'])->name('add-sparepart-inventory');
Route::post('/sparepart-inventory-save',[SparePartsInventoryController::class,'save'])->middleware(['auth'])->name('save-sparepart-inventory');

Route::get('/edit-profile',[GeneralController::class,'editProfile'])->name('edit-my-profile');
Route::post('/update-profile',[GeneralController::class,'updateProfile'])->middleware(['auth'])->name('update-profile');

Route::get('/invoice-list',[SparePartsInvoiceController::class,'index'])->name('list-sp-invoice');
Route::get('/invoice-add',[SparePartsInvoiceController::class,'add'])->name('add-sp-invoice');
Route::get('/serviceuser-detail/{id}', [SparePartsInvoiceController::class, 'detail'])->middleware(['auth'])->name('serviceuser-detail');
Route::get('/part-detail',[SparePartsInvoiceController::class,'partDetail'])->middleware(['auth'])->name('sparepart-detail-invoice');
Route::post('/invoice-save',[SparePartsInvoiceController::class,'save'])->middleware(['auth'])->name('saveinvoice');
Route::get('/sparepartinvoice-detail/{id}', [SparePartsInvoiceController::class, 'show'])->middleware(['auth'])->name('viewinvoice');
Route::get('/invoice-status/{id}', [SparePartsInvoiceController::class, 'update'])->middleware(['auth'])->name('change-invoice');
Route::get('/invoice-print/{id}', [SparePartsInvoiceController::class, 'printInvoice'])->middleware(['auth'])->name('printinvoice');
Route::get('/invoice-download/{id}', [SparePartsInvoiceController::class, 'downloadInvoice'])->middleware(['auth'])->name('downloadinvoice');
Route::get('/invoice-status-out-deliver/{id}', [SparePartsInvoiceController::class, 'statusOutToDeliver'])->middleware(['auth'])->name('out-deliver-order');
Route::post('/invoice-deliver',[SparePartsInvoiceController::class,'completeInvoice'])->middleware(['auth'])->name('deliver-invoice');


Route::get('/sparepart-request-list',[SparePartRequestController::class,'index'])->middleware(['auth'])->name('list-sp-request');
Route::get('/sparepart-request-detail/{id}', [SparePartRequestController::class, 'show'])->middleware(['auth'])->name('view-sparepart-request');




Route::get('/deliverynote-list',[DeliveryNoteController::class,'index'])->middleware(['auth'])->name('deliverynote-list');
Route::get('/deliverynote-add',[DeliveryNoteController::class,'add'])->middleware(['auth'])->name('deliverynote-add');
Route::get('/dealeruser-detail/{id}', [DeliveryNoteController::class, 'detailDealer'])->middleware(['auth'])->name('delaeruser-detail');
Route::get('/product-detail-deliverynote/{id}', [DeliveryNoteController::class, 'detailInverter'])->middleware(['auth'])->name('inverter-detail-dnote');
Route::post('/deliverynote-save',[DeliveryNoteController::class,'save'])->middleware(['auth'])->name('deliverynote-save');
Route::get('/deliverynote-view/{id}', [DeliveryNoteController::class, 'show'])->middleware(['auth'])->name('viewdeiverynote');
Route::get('/deliverynote-print/{id}', [DeliveryNoteController::class, 'printNote'])->middleware(['auth'])->name('printdeliverynote');
Route::get('/deliverynote-download/{id}', [DeliveryNoteController::class, 'downloadNote'])->middleware(['auth'])->name('download-deliverynote');



Route::get('/repairticket-list',[RepairTicketController::class,'index'])->name('lists-repair-ticket');
Route::get('/all-repairtickets',[RepairTicketController::class,'allTickets'])->name('all-repairs-ticket');
Route::get('/add-repairticket',[RepairTicketController::class,'add'])->middleware(['auth'])->name('create-repair-ticket');
Route::post('/searchserialnoforrepair',[RepairTicketController::class,'serachSn'])->middleware(['auth'])->name('serialnumber-search');
Route::get('/sp-detail-sc',[RepairTicketController::class,'partDetailForSc'])->middleware(['auth'])->name('sparepart-detail-sc');
Route::post('/repairnote-save',[RepairTicketController::class,'save'])->middleware(['auth'])->name('save-repairticket');
Route::get('/repair-ticket-detail/{id}', [RepairTicketController::class, 'show'])->middleware(['auth'])->name('view-repair-ticket');
Route::get('/repair-ticket-complete/{id}', [RepairTicketController::class, 'markAsComplete'])->middleware(['auth'])->name('complete-repair-ticket');
Route::get('/repair-ticket-edit/{id}', [RepairTicketController::class, 'editRepairTicket'])->middleware(['auth'])->name('edit-repair-ticket');
Route::post('/repairticket-update',[RepairTicketController::class,'update'])->middleware(['auth'])->name('update-repairticket');
Route::get('/repair-ticket-parts-request/{id}', [RepairTicketController::class, 'requestSpareParts'])->middleware(['auth'])->name('request-repair-ticket-spareparts');
Route::post('/repairticket-request-items',[RepairTicketController::class,'saverequestSparePart'])->middleware(['auth'])->name('repairticket-request-items');









require __DIR__.'/auth.php';
