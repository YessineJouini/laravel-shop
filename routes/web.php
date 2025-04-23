<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;

// Register alias for middleware?
Route::aliasMiddleware('checkrole', \App\Http\Middleware\CheckRole::class);

// main display
Route::get('/', function () {
    return Auth::check() ? redirect()->route('store.index') : redirect()->route('login');
});

// Admin dashboard (
Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'checkrole:admin'])->name('admin.dashboard');

// Admin routes
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
    Route::post('/orders/{order}/decline', [OrderController::class, 'decline'])->name('orders.decline');
});

// Public routes
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::resource('store', StoreController::class)->only(['index', 'show']);

// Auth routes
Auth::routes(['verify' => true]);

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/address/{address?}', [DashboardController::class, 'saveAddress'])
     ->name('dashboard.address.save');
Route::delete('/dashboard/address/{address}', [DashboardController::class, 'deleteAddress'])
     ->name('dashboard.address.delete');

    // Cart 
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/{productId}/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/checkout', [CartController::class, 'showCheckoutForm'])->name('cart.checkout.form');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/item/{itemId}/update', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/item/{itemId}', [CartController::class, 'removeItem'])->name('cart.removeItem');

});

// Order Confirmation 
Route::get('/order/confirmation/{order}', [CartController::class, 'showConfirmation'])->name('cart.confirmation');
