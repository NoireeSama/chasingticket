<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PartnerController as PartnerAdminController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\UserController as UserAdminController;
use App\Http\Controllers\ReviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'allEvents'])->name('events.all');
Route::get('/event/{event}', [EventController::class,'show'])->name('events.show');
Route::get('/organizer/{user}', [HomeController::class, 'organizerProfile'])->name('organizer.profile');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::post('/checkout/validate-coupon', [CheckoutController::class, 'validateCoupon'])->name('checkout.validateCoupon');
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/payment/{order_id}/expire', [CheckoutController::class, 'expire'])->name('checkout.expire');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

Route::post('/wishlist/toggle/{event}', [CustomerController::class, 'toggleWishlist'])->name('wishlist.toggle');
Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist.index')->middleware('auth');
Route::post('/cart/add/{event}', [CustomerController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CustomerController::class, 'cart'])->name('cart.index')->middleware('auth');
Route::delete('/cart/{cart}', [CustomerController::class, 'removeFromCart'])->name('cart.destroy')->middleware('auth');
Route::post('/cart/remove-by-event/{event}', [CustomerController::class, 'removeByEvent'])->name('cart.removeByEvent')->middleware('auth');
Route::post('/event/{event}/review', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::get('/settings', [CustomerController::class, 'settings'])->name('settings')->middleware('auth');
Route::put('/settings', [CustomerController::class, 'updateSettings'])->name('settings.update')->middleware('auth');
Route::get('/history', [CustomerController::class, 'history'])->name('history')->middleware('auth');
Route::get('/my-ticket/{order_id}', [EventController::class, 'showTicket'])->name('ticket.show')->middleware('auth');

Route::get('/storage/{path}', [StorageController::class, 'file'])->where('path', '.*');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::resource('events', EventAdminController::class);
        Route::resource('coupons', CouponController::class);
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::resource('feedbacks', \App\Http\Controllers\Admin\FeedbackController::class)->only(['index', 'destroy']);

        Route::middleware(['superadmin'])->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::resource('partners', PartnerAdminController::class);
            Route::resource('users', UserAdminController::class)->except(['show']);
        });
    });
});

Route::get('/run-migration', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true]);
        return 'Migrasi dan Seeding Berhasil!';
    } catch (\Exception $e) {
        return 'Terjadi Error: ' . $e->getMessage();
    }
});
Route::get('/run-seed', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed');
        return 'Seeding data berhasil dijalankan!';
    } catch (\Exception $e) {
        return 'Error Seeding: ' . $e->getMessage();
    }
});