<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PartnerController as PartnerAdminController;
use App\Http\Controllers\PartnerController;

// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{event}', [EventController::class,'show'])->name('events.show');
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/admin/partners', [PartnerController::class,'index'])->name('partners.index');
Route::get('/admin/partners/create', [PartnerController::class,'create'])->name('partners.create');

// Serve storage files - for both symlink and non-symlink environments
Route::get('/storage/{path}', [StorageController::class, 'file'])->where('path', '.*');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Catatan: Dashboard & Login Auth di kemudian hari akan menempati blok ini juga
    Route::resource('events', EventAdminController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('partners', PartnerAdminController::class);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    // dan seterusnya...
});
